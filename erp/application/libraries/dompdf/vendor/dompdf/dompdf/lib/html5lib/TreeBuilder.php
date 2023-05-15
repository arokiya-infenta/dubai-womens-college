<?php

/*

Copyright 2007 Jeroen van der Meer <http://jero.net/>
Copyright 2009 Edward Z. Yang <edwardzyang@thewritingpot.com>

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

// Tags for FIX ME!!!: (in order of priority)
//      XXX - should be fixed NAO!
//      XERROR - with regards to parse errors
//      XSCRIPT - with regards to scripting mode
//      XENCODING - with regards to encoding (for reparsing tests)
//      XDOM - DOM specific code (tagName is explicitly not marked).
//          this is not (yet) in helper functions.

class HTML5_TreeBuilder {
    public $stack = [];
    public $content_model;

    private $mode;
    private $original_mode;
    private $secondary_mode;
    private $dom;
    // Whether or not normal insertion of nodes should actually foster
    // parent (used in one case in spec)
    private $foster_parent = false;
    private $a_formatting  = [];

    private $head_pointer = null;
    private $form_pointer = null;

    private $flag_frameset_ok = true;
    private $flag_force_quirks = false;
    private $ignored = false;
    private $quirks_mode = null;
    // this gets to 2 when we want to ignore the next lf character, and
    // is decrement at the beginning of each processed token (this way,
    // code can check for (bool)$ignore_lf_token, but it phases out
    // appropriately)
    private $ignore_lf_token = 0;
    private $fragment = false;
    private $root;

    private $scoping = ['applet','button','caption','html','marquee','object','table','td','th', 'svg:foreignObject'];
    private $formatting = ['a','b','big','code','em','font','i','nobr','s','small','strike','strong','tt','u'];
    // dl and ds are speculative
    private $special = ['address','area','article','aside','base','basefont','bgsound',
    'blockquote','body','br','center','col','colgroup','command','dc','dd','details','dir','div','dl','ds',
    'dt','embed','fieldset','figure','footer','form','frame','frameset','h1','h2','h3','h4','h5',
    'h6','head','header','hgroup','hr','iframe','img','input','isindex','li','link',
    'listing','menu','meta','nav','noembed','noframes','noscript','ol',
    'p','param','plaintext','pre','script','select','spacer','style',
    'tbody','textarea','tfoot','thead','title','tr','ul','wbr'];

    private $pendingTableCharacters;
    private $pendingTableCharactersDirty;

    // Tree construction modes
    const INITIAL           = 0;
    const BEFORE_HTML       = 1;
    const BEFORE_HEAD       = 2;
    const IN_HEAD           = 3;
    const IN_HEAD_NOSCRIPT  = 4;
    const AFTER_HEAD        = 5;
    const IN_BODY           = 6;
    const IN_CDATA_RCDATA   = 7;
    const IN_TABLE          = 8;
    const IN_TABLE_TEXT     = 9;
    const IN_CAPTION        = 10;
    const IN_COLUMN_GROUP   = 11;
    const IN_TABLE_BODY     = 12;
    const IN_ROW            = 13;
    const IN_CELL           = 14;
    const IN_SELECT         = 15;
    const IN_SELECT_IN_TABLE= 16;
    const IN_FOREIGN_CONTENT= 17;
    const AFTER_BODY        = 18;
    const IN_FRAMESET       = 19;
    const AFTER_FRAMESET    = 20;
    const AFTER_AFTER_BODY  = 21;
    const AFTER_AFTER_FRAMESET = 22;

    /**
     * Converts a magic number to a readable name. Use for debugging.
     */
    private function strConst($number) {
        static $lookup;
        if (!$lookup) {
            $lookup = [];
            $r = new ReflectionClass('HTML5_TreeBuilder');
            $consts = $r->getConstants();
            foreach ($consts as $const => $num) {
                if (!is_int($num)) {
                    continue;
                }
                $lookup[$num] = $const;
            }
        }
        return $lookup[$number];
    }

    // The different types of elements.
    const SPECIAL    = 100;
    const SCOPING    = 101;
    const FORMATTING = 102;
    const PHRASING   = 103;

    // Quirks modes in $quirks_mode
    const NO_QUIRKS             = 200;
    const QUIRKS_MODE           = 201;
    const LIMITED_QUIRKS_MODE   = 202;

    // Marker to be placed in $a_formatting
    const MARKER     = 300;

    // Namespaces for foreign content
    const NS_HTML   = null; // to prevent DOM from requiring NS on everything
    const NS_MATHML = 'http://www.w3.org/1998/Math/MathML';
    const NS_SVG    = 'http://www.w3.org/2000/svg';
    const NS_XLINK  = 'http://www.w3.org/1999/xlink';
    const NS_XML    = 'http://www.w3.org/XML/1998/namespace';
    const NS_XMLNS  = 'http://www.w3.org/2000/xmlns/';

    // Different types of scopes to test for elements
    const SCOPE = 0;
    const SCOPE_LISTITEM = 1;
    const SCOPE_TABLE = 2;

    /**
     * HTML5_TreeBuilder constructor.
     */
    public function __construct() {
        $this->mode = self::INITIAL;
        $this->dom = new DOMDocument;

        $this->dom->encoding = 'UTF-8';
        $this->dom->preserveWhiteSpace = true;
        $this->dom->substituteEntities = true;
        $this->dom->strictErrorChecking = false;
    }

    public function getQuirksMode(){
      return $this->quirks_mode;
    }

    /**
     * Process tag tokens
     *
     * @param $token
     * @param null $mode
     */
    public function emitToken($token, $mode = null) {
        // XXX: ignore parse errors... why are we emitting them, again?
        if ($token['type'] === HTML5_Tokenizer::PARSEERROR) {
            return;
        }
        if ($mode === null) {
            $mode = $this->mode;
        }

        /*
        $backtrace = debug_backtrace();
        if ($backtrace[1]['class'] !== 'HTML5_TreeBuilder') echo "--\n";
        echo $this->strConst($mode);
        if ($this->original_mode) echo " (originally ".$this->strConst($this->original_mode).")";
        echo "\n  ";
        token_dump($token);
        $this->printStack();
        $this->printActiveFormattingElements();
        if ($this->foster_parent) echo "  -> this is a foster parent mode\n";
        if ($this->flag_frameset_ok) echo "  -> frameset ok\n";
        */

        if ($this->ignore_lf_token) {
            $this->ignore_lf_token--;
        }
        $this->ignored = false;

        switch ($mode) {
            case self::INITIAL:

                /* A character token that is one of U+0009 CHARACTER TABULATION,
                 * U+000A LINE FEED (LF), U+000C FORM FEED (FF),  or U+0020 SPACE */
                if ($token['type'] === HTML5_Tokenizer::SPACECHARACTER) {
                    /* Ignore the token. */
                    $this->ignored = true;
                } elseif ($token['type'] === HTML5_Tokenizer::DOCTYPE) {
                    if (
                        $token['name'] !== 'html' || !empty($token['public']) ||
                        !empty($token['system']) || $token !== 'about:legacy-compat'
                    ) {
                        /* If the DOCTYPE token's name is not a case-sensitive match
                         * for the string "html", or if the token's public identifier
                         * is not missing, or if the token's system identifier is
                         * neither missing nor a case-sensitive match for the string
                         * "about:legacy-compat", then there is a parse error (this
                         * is the DOCTYPE parse error). */
                        // DOCTYPE parse error
                    }
                    /* Append a DocumentType node to the Document node, with the name
                     * attribute set to the name given in the DOCTYPE token, or the
                     * empty string if the name was missing; the publicId attribute
                     * set to the public identifier given in the DOCTYPE token, or
                     * the empty string if the public identifier was missing; the
                     * systemId attribute set to the system identifier given in the
                     * DOCTYPE token, or the empty string if the system identifier
                     * was missing; and the other attributes specific to
                     * DocumentType objects set to null and empty lists as
                     * appropriate. Associate the DocumentType node with the
                     * Document object so that it is returned as the value of the
                     * doctype attribute of the Document object. */
                    if (!isset($token['public'])) {
                        $token['public'] = "";
                    }
                    if (!isset($token['system'])) {
                        $token['system'] = "";
                    }
                    // XDOM
                    // Yes this is hacky. I'm kind of annoyed that I can't appendChild
                    // a doctype to DOMDocument. Maybe I haven't chanted the right
                    // syllables.
                    $impl = new DOMImplementation();
                    // This call can fail for particularly pathological cases (namely,
                    // the qualifiedName parameter ($token['name']) could be missing.
                    if ($token['name']) {
                        $doctype = $impl->createDocumentType($token['name'], $token['public'], $token['system']);
                        $this->dom->appendChild($doctype);
                    } else {
                        // It looks like libxml's not actually *able* to express this case.
                        // So... don't.
                        $this->dom->emptyDoctype = true;
                    }
                    $public = strtolower($token['public']);
                    $system = $token['system'] === "" ? false : strtolower($token['system']);
                    $publicStartsWithForQuirks = [
                     "+//silmaril//dtd html pro v0r11 19970101//",
                     "-//advasoft ltd//dtd html 3.0 aswedit + extensions//",
                     "-//as//dtd html 3.0 aswedit + extensions//",
                     "-//ietf//dtd html 2.0 level 1//",
                     "-//ietf//dtd html 2.0 level 2//",
                     "-//ietf//dtd html 2.0 strict level 1//",
                     "-//ietf//dtd html 2.0 strict level 2//",
                     "-//ietf//dtd html 2.0 strict//",
                     "-//ietf//dtd html 2.0//",
                     "-//ietf//dtd html 2.1e//",
                     "-//ietf//dtd html 3.0//",
                     "-//ietf//dtd html 3.2 final//",
                     "-//ietf//dtd html 3.2//",
                     "-//ietf//dtd html 3//",
                     "-//ietf//dtd html level 0//",
                     "-//ietf//dtd html level 1//",
                     "-//ietf//dtd html level 2//",
                     "-//ietf//dtd html level 3//",
                     "-//ietf//dtd html strict level 0//",
                     "-//ietf//dtd html strict level 1//",
                     "-//ietf//dtd html strict level 2//",
                     "-//ietf//dtd html strict level 3//",
                     "-//ietf//dtd html strict//",
                     "-//ietf//dtd html//",
                     "-//metrius//dtd metrius presentational//",
                     "-//microsoft//dtd internet explorer 2.0 html strict//",
                     "-//microsoft//dtd internet explorer 2.0 html//",
                     "-//microsoft//dtd internet explorer 2.0 tables//",
                     "-//microsoft//dtd internet explorer 3.0 html strict//",
                     "-//microsoft//dtd internet explorer 3.0 html//",
                     "-//microsoft//dtd internet explorer 3.0 tables//",
                     "-//netscape comm. corp.//dtd html//",
                     "-//netscape comm. corp.//dtd strict html//",
                     "-//o'reilly and associates//dtd html 2.0//",
                     "-//o'reilly and associates//dtd html extended 1.0//",
                     "-//o'reilly and associates//dtd html extended relaxed 1.0//",
                     "-//spyglass//dtd html 2.0 extended//",
                     "-//sq//dtd html 2.0 hotmetal + extensions//",
                     "-//sun microsystems corp.//dtd hotjava html//",
                     "-//sun microsystems corp.//dtd hotjava strict html//",
                     "-//w3c//dtd html 3 1995-03-24//",
                     "-//w3c//dtd html 3.2 draft//",
                     "-//w3c//dtd html 3.2 final//",
                     "-//w3c//dtd html 3.2//",
                     "-//w3c//dtd html 3.2s draft//",
                     "-//w3c//dtd html 4.0 frameset//",
                     "-//w3c//dtd html 4.0 transitional//",
                     "-//w3c//dtd html experimental 19960712//",
                     "-//w3c//dtd html experimental 970421//",
                     "-//w3c//dtd w3 html//",
                     "-//w3o//dtd w3 html 3.0//",
                     "-//webtechs//dtd mozilla html 2.0//",
                     "-//webtechs//dtd mozilla html//",
                    ];
                    $publicSetToForQuirks = [
                     "-//w3o//dtd w3 html strict 3.0//",
                     "-/w3c/dtd html 4.0 transitional/en",
                     "html",
                    ];
                    $publicStartsWithAndSystemForQuirks = [
                     "-//w3c//dtd html 4.01 frameset//",
                     "-//w3c//dtd html 4.01 transitional//",
                    ];
                    $publicStartsWithForLimitedQuirks = [
                     "-//w3c//dtd xhtml 1.0 frameset//",
                     "-//w3c//dtd xhtml 1.0 transitional//",
                    ];
                    $publicStartsWithAndSystemForLimitedQuirks = [
                     "-//w3c//dtd html 4.01 frameset//",
                     "-//w3c//dtd html 4.01 transitional//",
                    ];
                    // first, do easy checks
                    if (
                        !empty($token['force-quirks']) ||
                        strtolower($token['name']) !== 'html'
                    ) {
                        $this->quirks_mode = self::QUIRKS_MODE;
                    } else {
                        do {
                            if ($system) {
                                foreach ($publicStartsWithAndSystemForQuirks as $x) {
                                    if (strncmp($public, $x, strlen($x)) === 0) {
                                        $this->quirks_mode = self::QUIRKS_MODE;
                                        break;
                                    }
                                }
                                if (!is_null($this->quirks_mode)) {
                                    break;
                                }
                                foreach ($publicStartsWithAndSystemForLimitedQuirks as $x) {
                                    if (strncmp($public, $x, strlen($x)) === 0) {
                                        $this->quirks_mode = self::LIMITED_QUIRKS_MODE;
                                        break;
                                    }
                                }
                                if (!is_null($this->quirks_mode)) {
                                    break;
                                }
                            }
                            foreach ($publicSetToForQuirks as $x) {
                                if ($public === $x) {
                                    $this->quirks_mode = self::QUIRKS_MODE;
                                    break;
                                }
                            }
                            if (!is_null($this->quirks_mode)) {
                                break;
                            }
                            foreach ($publicStartsWithForLimitedQuirks as $x) {
                                if (strncmp($public, $x, strlen($x)) === 0) {
                                    $this->quirks_mode = self::LIMITED_QUIRKS_MODE;
                                }
                            }
                            if (!is_null($this->quirks_mode)) {
                                break;
                            }
                            if ($system === "http://www.ibm.com/data/dtd/v11/ibmxhtml1-transitional.dtd") {
                                $this->quirks_mode = self::QUIRKS_MODE;
                                break;
                            }
                            foreach ($publicStartsWithForQuirks as $x) {
                                if (strncmp($public, $x, strlen($x)) === 0) {
                                    $this->quirks_mode = self::QUIRKS_MODE;
                                    break;
                                }
                            }
                            if (is_null($this->quirks_mode)) {
                                $this->quirks_mode = self::NO_QUIRKS;
                            }
                        } while (false);
                    }
                    $this->mode = self::BEFORE_HTML;
                } else {
                    // parse error
                    /* Switch the insertion mode to "before html", then reprocess the
                     * current token. */
                    $this->mode = self::BEFORE_HTML;
                    $this->quirks_mode = self::QUIRKS_MODE;
                    $this->emitToken($token);
                }
                break;

            case self::BEFORE_HTML:
                /* A DOCTYPE token */
                if ($token['type'] === HTML5_Tokenizer::DOCTYPE) {
                    // Parse error. Ignore the token.
                    $this->ignored = true;

                /* A comment token */
                } elseif ($token['type'] === HTML5_Tokenizer::COMMENT) {
                    /* Append a Comment node to the Document object with the data
                    attribute set to the data given in the comment token. */
                    // XDOM
                    $comment = $this->dom->createComment($token['data']);
                    $this->dom->appendChild($comment);

                /* A character token that is one of one of U+0009 CHARACTER TABULATION,
                U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
                or U+0020 SPACE */
                } elseif ($token['type'] === HTML5_Tokenizer::SPACECHARACTER) {
                    /* Ignore the token. */
                    $this->ignored = true;

                /* A start tag whose tag name is "html" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] == 'html') {
                    /* Create an element for the token in the HTML namespace. Append it
                     * to the Document  object. Put this element in the stack of open
                     * elements. */
                    // XDOM
                    $html = $this->insertElement($token, false);
                    $this->dom->appendChild($html);
                    $this->stack[] = $html;

                    $this->mode = self::BEFORE_HEAD;

                } else {
                    /* Create an html element. Append it to the Document object. Put
                     * this element in the stack of open elements. */
                    // XDOM
                    $html = $this->dom->createElementNS(self::NS_HTML, 'html');
                    $this->dom->appendChild($html);
                    $this->stack[] = $html;

                    /* Switch the insertion mode to "before head", then reprocess the
                     * current token. */
                    $this->mode = self::BEFORE_HEAD;
                    $this->emitToken($token);
                }
                break;

            case self::BEFORE_HEAD:
                /* A character token that is one of one of U+0009 CHARACTER TABULATION,
                U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
                or U+0020 SPACE */
                if ($token['type'] === HTML5_Tokenizer::SPACECHARACTER) {
                    /* Ignore the token. */
                    $this->ignored = true;

                /* A comment token */
                } elseif ($token['type'] === HTML5_Tokenizer::COMMENT) {
                    /* Append a Comment node to the current node with the data attribute
                    set to the data given in the comment token. */
                    $this->insertComment($token['data']);

                /* A DOCTYPE token */
                } elseif ($token['type'] === HTML5_Tokenizer::DOCTYPE) {
                    /* Parse error. Ignore the token */
                    $this->ignored = true;
                    // parse error

                /* A start tag token with the tag name "html" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'html') {
                    /* Process the token using the rules for the "in body"
                     * insertion mode. */
                    $this->processWithRulesFor($token, self::IN_BODY);

                /* A start tag token with the tag name "head" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'head') {
                    /* Insert an HTML element for the token. */
                    $element = $this->insertElement($token);

                    /* Set the head element pointer to this new element node. */
                    $this->head_pointer = $element;

                    /* Change the insertion mode to "in head". */
                    $this->mode = self::IN_HEAD;

                /* An end tag whose tag name is one of: "head", "body", "html", "br" */
                } elseif (
                    $token['type'] === HTML5_Tokenizer::ENDTAG && (
                        $token['name'] === 'head' || $token['name'] === 'body' ||
                        $token['name'] === 'html' || $token['name'] === 'br'
                )) {
                    /* Act as if a start tag token with the tag name "head" and no
                     * attributes had been seen, then reprocess the current token. */
                    $this->emitToken([
                        'name' => 'head',
                        'type' => HTML5_Tokenizer::STARTTAG,
                        'attr' => []
                    ]);
                    $this->emitToken($token);

                /* Any other end tag */
                } elseif ($token['type'] === HTML5_Tokenizer::ENDTAG) {
                    /* Parse error. Ignore the token. */
                    $this->ignored = true;

                } else {
                    /* Act as if a start tag token with the tag name "head" and no
                     * attributes had been seen, then reprocess the current token.
                     * Note: This will result in an empty head element being
                     * generated, with the current token being reprocessed in the
                     * "after head" insertion mode. */
                    $this->emitToken([
                        'name' => 'head',
                        'type' => HTML5_Tokenizer::STARTTAG,
                        'attr' => []
                    ]);
                    $this->emitToken($token);
                }
                break;

            case self::IN_HEAD:
                /* A character token that is one of one of U+0009 CHARACTER TABULATION,
                U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
                or U+0020 SPACE. */
                if ($token['type'] === HTML5_Tokenizer::SPACECHARACTER) {
                    /* Insert the character into the current node. */
                    $this->insertText($token['data']);

                /* A comment token */
                } elseif ($token['type'] === HTML5_Tokenizer::COMMENT) {
                    /* Append a Comment node to the current node with the data attribute
                    set to the data given in the comment token. */
                    $this->insertComment($token['data']);

                /* A DOCTYPE token */
                } elseif ($token['type'] === HTML5_Tokenizer::DOCTYPE) {
                    /* Parse error. Ignore the token. */
                    $this->ignored = true;
                    // parse error

                /* A start tag whose tag name is "html" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG &&
                $token['name'] === 'html') {
                    $this->processWithRulesFor($token, self::IN_BODY);

                /* A start tag whose tag name is one of: "base", "command", "link" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG &&
                ($token['name'] === 'base' || $token['name'] === 'command' ||
                $token['name'] === 'link')) {
                    /* Insert an HTML element for the token. Immediately pop the
                     * current node off the stack of open elements. */
                    $this->insertElement($token);
                    array_pop($this->stack);

                    // YYY: Acknowledge the token's self-closing flag, if it is set.

                /* A start tag whose tag name is "meta" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'meta') {
                    /* Insert an HTML element for the token. Immediately pop the
                     * current node off the stack of open elements. */
                    $this->insertElement($token);
                    array_pop($this->stack);

                    // XERROR: Acknowledge the token's self-closing flag, if it is set.

                    // XENCODING: If the element has a charset attribute, and its value is a
                    // supported encoding, and the confidence is currently tentative,
                    // then change the encoding to the encoding given by the value of
                    // the charset attribute.
                    //
                    // Otherwise, if the element has a content attribute, and applying
                    // the algorithm for extracting an encoding from a Content-Type to
                    // its value returns a supported encoding encoding, and the
                    // confidence is currently tentative, then change the encoding to
                    // the encoding encoding.

                /* A start tag with the tag name "title" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'title') {
                    $this->insertRCDATAElement($token);

                /* A start tag whose tag name is "noscript", if the scripting flag is enabled, or
                 * A start tag whose tag name is one of: "noframes", "style" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG &&
                ($token['name'] === 'noscript' || $token['name'] === 'noframes' || $token['name'] === 'style')) {
                    // XSCRIPT: Scripting flag not respected
                    $this->insertCDATAElement($token);

                // XSCRIPT: Scripting flag disable not implemented

                /* A start tag with the tag name "script" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'script') {
                    /* 1. Create an element for the token in the HTML namespace. */
                    $node = $this->insertElement($token, false);

                    /* 2. Mark the element as being "parser-inserted" */
                    // Uhhh... XSCRIPT

                    /* 3. If the parser was originally created for the HTML
                     * fragment parsing algorithm, then mark the script element as
                     * "already executed". (fragment case) */
                    // ditto... XSCRIPT

                    /* 4. Append the new element to the current node  and push it onto
                     * the stack of open elements.  */
                    end($this->stack)->appendChild($node);
                    $this->stack[] = $node;
                    // I guess we could squash these together

                    /* 6. Let the original insertion mode be the current insertion mode. */
                    $this->original_mode = $this->mode;
                    /* 7. Switch the insertion mode to "in CDATA/RCDATA" */
                    $this->mode = self::IN_CDATA_RCDATA;
                    /* 5. Switch the tokeniser's content model flag to the CDATA state. */
                    $this->content_model = HTML5_Tokenizer::CDATA;

                /* An end tag with the tag name "head" */
                } elseif ($token['type'] === HTML5_Tokenizer::ENDTAG && $token['name'] === 'head') {
                    /* Pop the current node (which will be the head element) off the stack of open elements. */
                    array_pop($this->stack);

                    /* Change the insertion mode to "after head". */
                    $this->mode = self::AFTER_HEAD;

                // Slight logic inversion here to minimize duplication
                /* A start tag with the tag name "head". */
                /* An end tag whose tag name is not one of: "body", "html", "br" */
                } elseif (($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'head') ||
                ($token['type'] === HTML5_Tokenizer::ENDTAG && $token['name'] !== 'html' &&
                $token['name'] !== 'body' && $token['name'] !== 'br')) {
                    // Parse error. Ignore the token.
                    $this->ignored = true;

                /* Anything else */
                } else {
                    /* Act as if an end tag token with the tag name "head" had been
                     * seen, and reprocess the current token. */
                    $this->emitToken([
                        'name' => 'head',
                        'type' => HTML5_Tokenizer::ENDTAG
                    ]);

                    /* Then, reprocess the current token. */
                    $this->emitToken($token);
                }
                break;

            case self::IN_HEAD_NOSCRIPT:
                if ($token['type'] === HTML5_Tokenizer::DOCTYPE) {
                    // parse error
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'html') {
                    $this->processWithRulesFor($token, self::IN_BODY);
                } elseif ($token['type'] === HTML5_Tokenizer::ENDTAG && $token['name'] === 'noscript') {
                    /* Pop the current node (which will be a noscript element) from the
                     * stack of open elements; the new current node will be a head
                     * element. */
                    array_pop($this->stack);
                    $this->mode = self::IN_HEAD;
                } elseif (
                    ($token['type'] === HTML5_Tokenizer::SPACECHARACTER) ||
                    ($token['type'] === HTML5_Tokenizer::COMMENT) ||
                    ($token['type'] === HTML5_Tokenizer::STARTTAG && (
                        $token['name'] === 'link' || $token['name'] === 'meta' ||
                        $token['name'] === 'noframes' || $token['name'] === 'style'))) {
                    $this->processWithRulesFor($token, self::IN_HEAD);
                // inverted logic
                } elseif (
                    ($token['type'] === HTML5_Tokenizer::STARTTAG && (
                        $token['name'] === 'head' || $token['name'] === 'noscript')) ||
                    ($token['type'] === HTML5_Tokenizer::ENDTAG &&
                        $token['name'] !== 'br')) {
                    // parse error
                } else {
                    // parse error
                    $this->emitToken([
                        'type' => HTML5_Tokenizer::ENDTAG,
                        'name' => 'noscript',
                    ]);
                    $this->emitToken($token);
                }
                break;

            case self::AFTER_HEAD:
                /* Handle the token as follows: */

                /* A character token that is one of one of U+0009 CHARACTER TABULATION,
                U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
                or U+0020 SPACE */
                if ($token['type'] === HTML5_Tokenizer::SPACECHARACTER) {
                    /* Append the character to the current node. */
                    $this->insertText($token['data']);

                /* A comment token */
                } elseif ($token['type'] === HTML5_Tokenizer::COMMENT) {
                    /* Append a Comment node to the current node with the data attribute
                    set to the data given in the comment token. */
                    $this->insertComment($token['data']);

                } elseif ($token['type'] === HTML5_Tokenizer::DOCTYPE) {
                    // parse error

                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'html') {
                    $this->processWithRulesFor($token, self::IN_BODY);

                /* A start tag token with the tag name "body" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'body') {
                    $this->insertElement($token);

                    /* Set the frameset-ok flag to "not ok". */
                    $this->flag_frameset_ok = false;

                    /* Change the insertion mode to "in body". */
                    $this->mode = self::IN_BODY;

                /* A start tag token with the tag name "frameset" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'frameset') {
                    /* Insert a frameset element for the token. */
                    $this->insertElement($token);

                    /* Change the insertion mode to "in frameset". */
                    $this->mode = self::IN_FRAMESET;

                /* A start tag token whose tag name is one of: "base", "link", "meta",
                "script", "style", "title" */
                } elseif ($token['type'] === HTML5_Tokenizer::STARTTAG && in_array($token['name'],
                ['base', 'link', 'meta', 'noframes', 'script', 'style', 'title'])) {
                    // parse error
                    /* Push the node pointed to by the head element pointer onto the
                     * stack of open elements. */
                    $this->stack[] = $this->head_pointer;
                    $this->processWithRulesFor($token, self::IN_HEAD);
                    array_splice($this->stack, array_search($this->head_pointer, $this->stack, true), 1);

                // inversion of specification
                } elseif (
                ($token['type'] === HTML5_Tokenizer::STARTTAG && $token['name'] === 'head') ||
                ($token['type'] === HTML5_Tokenizer::ENDTAG &&
                    $token['name'] !== 'body' && $token['name'] !== 'html' &&
                    $token['name'] !== 'br')) {
                    // parse error

                /* Anything else */
                } else {
                    $this->emitToken([
                        'name' => 'body',
                        'type' => HTML5_Tokenizer::STARTTAG,
                        'attr' => []
                    ]);
                    $this->flag_frameset_ok = true;
                    $this->emitToken($token);
                }
                break;

            case self::IN_BODY:
                /* Handle the token as follows: */

                switch($token['type']) {
                    /* A character token */
                    case HTML5_Tokenizer::CHARACTER:
                    case HTML5_Tokenizer::SPACECHARACTER:
                        /* Reconstruct the active formatting elements, if any. */
                        $this->reconstructActiveFormattingElements();

                        /* Append the token's character to the current node. */
                        $this->insertText($token['data']);

                        /* If the token is not one of U+0009 CHARACTER TABULATION,
                         * U+000A LINE FEED (LF), U+000C FORM FEED (FF),  or U+0020
                         * SPACE, then set the frameset-ok flag to "not ok". */
                        // i.e., if any of the characters is not whitespace
                        if (strlen($token['data']) !== strspn($token['data'], HTML5_Tokenizer::WHITESPACE)) {
                            $this->flag_frameset_ok = false;
                        }
                    break;

                    /* A comment token */
                    case HTML5_Tokenizer::COMMENT:
                        /* Append a Comment node to the current node with the data
                        attribute set to the data given in the comment token. */
                        $this->insertComment($token['data']);
                    break;

                    case HTML5_Tokenizer::DOCTYPE:
                        // parse error
                    break;

                    case HTML5_Tokenizer::EOF:
                        // parse error
                    break;

                    case HTML5_Tokenizer::STARTTAG:
                    switch($token['name']) {
                        case 'html':
                            // parse error
                            /* For each attribute on the token, check to see if the
                             * attribute is already present on the top element of the
                             * stack of open elements. If it is not, add the attribute
                             * and its corresponding value to that element. */
                            foreach($token['attr'] as $attr) {
                                if (!$this->stack[0]->hasAttribute($attr['name'])) {
                                    $this->stack[0]->setAttribute($attr['name'], $attr['value']);
                                }
                            }
                        break;

                        case 'base': case 'command': case 'link': case 'meta': case 'noframes':
                        case 'script': case 'style': case 'title':
                            /* Process the token as if the insertion mode had been "in
                            head". */
                            $this->processWithRulesFor($token, self::IN_HEAD);
                        break;

                        /* A start tag token with the tag name "body" */
                        case 'body':
                            /* Parse error. If the second element on the stack of open
                            elements is not a body element, or, if the stack of open
                            elements has only one node on it, then ignore the token.
                            (fragment case) */
                            if (count($this->stack) === 1 || $this->stack[1]->tagName !== 'body') {
                                $this->ignored = true;
                                // Ignore

                            /* Otherwise, for each attribute on the token, check to see
                            if the attribute is already present on the body element (the
                            second element)    on the stack of open elements. If it is not,
                            add the attribute and its corresponding value to that
                            element. */
                            } else {
                                foreach($token['attr'] as $attr) {
                                    if (!$this->stack[1]->hasAttribute($attr['name'])) {
                                        $this->stack[1]->setAttribute($attr['name'], $attr['value']);
                                    }
                                }
                            }
                        break;

                        case 'frameset':
                            // parse error
                            /* If the second element on the stack of open elements is
                             * not a body element, or, if the stack of open elements
                             * has only one node on it, then ignore the token.
                             * (fragment case) */
                            if (count($this->stack) === 1 || $this->stack[1]->tagName !== 'body') {
                                $this->ignored = true;
                                // Ignore
                            } elseif (!$this->flag_frameset_ok) {
                                $this->ignored = true;
                                // Ignore
                            } else {
                                /* 1. Remove the second element on the stack of open
                                 * elements from its parent node, if it has one.  */
                                if ($this->stack[1]->parentNode) {
                                    $this->stack[1]->parentNode->removeChild($this->stack[1]);
                                }

                                /* 2. Pop all the nodes from the bottom of the stack of
                                 * open elements, from the current node up to the root
                                 * html element. */
                                array_splice($this->stack, 1);

                                $this->insertElement($token);
                                $this->mode = self::IN_FRAMESET;
                            }
                        break;

                        // in spec, there is a diversion here

                        case 'address': case 'article': case 'aside': case 'blockquote':
                        case 'center': case 'datagrid': case 'details': case 'dir':
                        case 'div': case 'dl': case 'fieldset': case 'figure': case 'footer':
                        case 'header': case 'hgroup': case 'menu': case 'nav':
                        case 'ol': case 'p': case 'section': case 'ul':
                            /* If the stack of open elements has a p element in scope,
                            then act as if an end tag with the tag name p had been
                            seen. */
                            if ($this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);
                        break;

                        /* A start tag whose tag name is one of: "h1", "h2", "h3", "h4",
                        "h5", "h6" */
                        case 'h1': case 'h2': case 'h3': case 'h4': case 'h5': case 'h6':
                            /* If the stack of open elements has a p  element in scope,
                            then act as if an end tag with the tag name p had been seen. */
                            if ($this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* If the current node is an element whose tag name is one
                             * of "h1", "h2", "h3", "h4", "h5", or "h6", then this is a
                             * parse error; pop the current node off the stack of open
                             * elements. */
                            $peek = array_pop($this->stack);
                            if (in_array($peek->tagName, ["h1", "h2", "h3", "h4", "h5", "h6"])) {
                                // parse error
                            } else {
                                $this->stack[] = $peek;
                            }

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);
                        break;

                        case 'pre': case 'listing':
                            /* If the stack of open elements has a p  element in scope,
                            then act as if an end tag with the tag name p had been seen. */
                            if ($this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }
                            $this->insertElement($token);
                            /* If the next token is a U+000A LINE FEED (LF) character
                             * token, then ignore that token and move on to the next
                             * one. (Newlines at the start of pre blocks are ignored as
                             * an authoring convenience.) */
                            $this->ignore_lf_token = 2;
                            $this->flag_frameset_ok = false;
                        break;

                        /* A start tag whose tag name is "form" */
                        case 'form':
                            /* If the form element pointer is not null, ignore the
                            token with a parse error. */
                            if ($this->form_pointer !== null) {
                                $this->ignored = true;
                                // Ignore.

                            /* Otherwise: */
                            } else {
                                /* If the stack of open elements has a p element in
                                scope, then act as if an end tag with the tag name p
                                had been seen. */
                                if ($this->elementInScope('p')) {
                                    $this->emitToken([
                                        'name' => 'p',
                                        'type' => HTML5_Tokenizer::ENDTAG
                                    ]);
                                }

                                /* Insert an HTML element for the token, and set the
                                form element pointer to point to the element created. */
                                $element = $this->insertElement($token);
                                $this->form_pointer = $element;
                            }
                        break;

                        // condensed specification
                        case 'li': case 'dc': case 'dd': case 'ds': case 'dt':
                            /* 1. Set the frameset-ok flag to "not ok". */
                            $this->flag_frameset_ok = false;

                            $stack_length = count($this->stack) - 1;
                            for($n = $stack_length; 0 <= $n; $n--) {
                                /* 2. Initialise node to be the current node (the
                                bottommost node of the stack). */
                                $stop = false;
                                $node = $this->stack[$n];
                                $cat  = $this->getElementCategory($node);

                                // for case 'li':
                                /* 3. If node is an li element, then act as if an end
                                 * tag with the tag name "li" had been seen, then jump
                                 * to the last step.  */
                                // for case 'dc': case 'dd': case 'ds': case 'dt':
                                /* If node is a dc, dd, ds or dt element, then act as if an end
                                 * tag with the same tag name as node had been seen, then
                                 * jump to the last step. */
                                if (($token['name'] === 'li' && $node->tagName === 'li') ||
                                ($token['name'] !== 'li' && ($node->tagName == 'dc' || $node->tagName === 'dd' || $node->tagName == 'ds' || $node->tagName === 'dt'))) { // limited conditional
                                    $this->emitToken([
                                        'type' => HTML5_Tokenizer::ENDTAG,
                                        'name' => $node->tagName,
                                    ]);
                                    break;
                                }

                                /* 4. If node is not in the formatting category, and is
                                not    in the phrasing category, and is not an address,
                                div or p element, then stop this algorithm. */
                                if ($cat !== self::FORMATTING && $cat !== self::PHRASING &&
                                $node->tagName !== 'address' && $node->tagName !== 'div' &&
                                $node->tagName !== 'p') {
                                    break;
                                }

                                /* 5. Otherwise, set node to the previous entry in the
                                 * stack of open elements and return to step 2. */
                            }

                            /* 6. This is the last step. */

                            /* If the stack of open elements has a p  element in scope,
                            then act as if an end tag with the tag name p had been
                            seen. */
                            if ($this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* Finally, insert an HTML element with the same tag
                            name as the    token's. */
                            $this->insertElement($token);
                        break;

                        /* A start tag token whose tag name is "plaintext" */
                        case 'plaintext':
                            /* If the stack of open elements has a p  element in scope,
                            then act as if an end tag with the tag name p had been
                            seen. */
                            if ($this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            $this->content_model = HTML5_Tokenizer::PLAINTEXT;
                        break;

                        // more diversions

                        /* A start tag whose tag name is "a" */
                        case 'a':
                            /* If the list of active formatting elements contains
                            an element whose tag name is "a" between the end of the
                            list and the last marker on the list (or the start of
                            the list if there is no marker on the list), then this
                            is a parse error; act as if an end tag with the tag name
                            "a" had been seen, then remove that element from the list
                            of active formatting elements and the stack of open
                            elements if the end tag didn't already remove it (it
                            might not have if the element is not in table scope). */
                            $leng = count($this->a_formatting);

                            for ($n = $leng - 1; $n >= 0; $n--) {
                                if ($this->a_formatting[$n] === self::MARKER) {
                                    break;

                                } elseif ($this->a_formatting[$n]->tagName === 'a') {
                                    $a = $this->a_formatting[$n];
                                    $this->emitToken([
                                        'name' => 'a',
                                        'type' => HTML5_Tokenizer::ENDTAG
                                    ]);
                                    if (in_array($a, $this->a_formatting)) {
                                        $a_i = array_search($a, $this->a_formatting, true);
                                        if ($a_i !== false) {
                                            array_splice($this->a_formatting, $a_i, 1);
                                        }
                                    }
                                    if (in_array($a, $this->stack)) {
                                        $a_i = array_search($a, $this->stack, true);
                                        if ($a_i !== false) {
                                            array_splice($this->stack, $a_i, 1);
                                        }
                                    }
                                    break;
                                }
                            }

                            /* Reconstruct the active formatting elements, if any. */
                            $this->reconstructActiveFormattingElements();

                            /* Insert an HTML element for the token. */
                            $el = $this->insertElement($token);

                            /* Add that element to the list of active formatting
                            elements. */
                            $this->a_formatting[] = $el;
                        break;

                        case 'b': case 'big': case 'code': case 'em': case 'font': case 'i':
                        case 's': case 'small': case 'strike':
                        case 'strong': case 'tt': case 'u':
                            /* Reconstruct the active formatting elements, if any. */
                            $this->reconstructActiveFormattingElements();

                            /* Insert an HTML element for the token. */
                            $el = $this->insertElement($token);

                            /* Add that element to the list of active formatting
                            elements. */
                            $this->a_formatting[] = $el;
                        break;

                        case 'nobr':
                            /* Reconstruct the active formatting elements, if any. */
                            $this->reconstructActiveFormattingElements();

                            /* If the stack of open elements has a nobr element in
                             * scope, then this is a parse error; act as if an end tag
                             * with the tag name "nobr" had been seen, then once again
                             * reconstruct the active formatting elements, if any. */
                            if ($this->elementInScope('nobr')) {
                                $this->emitToken([
                                    'name' => 'nobr',
                                    'type' => HTML5_Tokenizer::ENDTAG,
                                ]);
                                $this->reconstructActiveFormattingElements();
                            }

                            /* Insert an HTML element for the token. */
                            $el = $this->insertElement($token);

                            /* Add that element to the list of active formatting
                            elements. */
                            $this->a_formatting[] = $el;
                        break;

                        // another diversion

                        /* A start tag token whose tag name is "button" */
                        case 'button':
                            /* If the stack of open elements has a button element in scope,
                            then this is a parse error; act as if an end tag with the tag
                            name "button" had been seen, then reprocess the token. (We don't
                            do that. Unnecessary.) (I hope you're right! -- ezyang) */
                            if ($this->elementInScope('button')) {
                                $this->emitToken([
                                    'name' => 'button',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* Reconstruct the active formatting elements, if any. */
                            $this->reconstructActiveFormattingElements();

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            /* Insert a marker at the end of the list of active
                            formatting elements. */
                            $this->a_formatting[] = self::MARKER;

                            $this->flag_frameset_ok = false;
                        break;

                        case 'applet': case 'marquee': case 'object':
                            /* Reconstruct the active formatting elements, if any. */
                            $this->reconstructActiveFormattingElements();

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            /* Insert a marker at the end of the list of active
                            formatting elements. */
                            $this->a_formatting[] = self::MARKER;

                            $this->flag_frameset_ok = false;
                        break;

                        // spec diversion

                        /* A start tag whose tag name is "table" */
                        case 'table':
                            /* If the Document is not set to quirks mode, and the
                             * stack of open elements has a p element in scope, then
                             * act as if an end tag with the tag name "p" had been
                             * seen. */
                            if ($this->quirks_mode !== self::QUIRKS_MODE &&
                            $this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            $this->flag_frameset_ok = false;

                            /* Change the insertion mode to "in table". */
                            $this->mode = self::IN_TABLE;
                        break;

                        /* A start tag whose tag name is one of: "area", "basefont",
                        "bgsound", "br", "embed", "img", "param", "spacer", "wbr" */
                        case 'area': case 'basefont': case 'bgsound': case 'br':
                        case 'embed': case 'img': case 'input': case 'keygen': case 'spacer':
                        case 'wbr':
                            /* Reconstruct the active formatting elements, if any. */
                            $this->reconstructActiveFormattingElements();

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            /* Immediately pop the current node off the stack of open elements. */
                            array_pop($this->stack);

                            // YYY: Acknowledge the token's self-closing flag, if it is set.

                            $this->flag_frameset_ok = false;
                        break;

                        case 'param': case 'source':
                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            /* Immediately pop the current node off the stack of open elements. */
                            array_pop($this->stack);

                            // YYY: Acknowledge the token's self-closing flag, if it is set.
                        break;

                        /* A start tag whose tag name is "hr" */
                        case 'hr':
                            /* If the stack of open elements has a p element in scope,
                            then act as if an end tag with the tag name p had been seen. */
                            if ($this->elementInScope('p')) {
                                $this->emitToken([
                                    'name' => 'p',
                                    'type' => HTML5_Tokenizer::ENDTAG
                                ]);
                            }

                            /* Insert an HTML element for the token. */
                            $this->insertElement($token);

                            /* Immediately pop the current node off the stack of open elements. */
                            array_pop($this->stack);

                            // YYY: Acknowledge the token's self-closing flag, if it is set.

                            $this->flag_frameset_ok = false;
                        break;

                        /* A start tag whose tag name is "image" */
                        case 'image':
                            /* Parse error. Change the token's tag name to "img" and
                            reprocess it. (Don't ask.) */
                            $token['name'] = 'img';
                            $this->emitToken($token);
                        break;

                        /* A start tag whose tag name is "isindex" */
                        case 'isindex':
                            /* Parse error. */

                            /* If the form element pointer is not null,
                            then ignore the token. */
                            if ($this->form_pointer === null) {
                                /* Act as if a start tag token with the tag name "form" had
                                been seen. */
                                /* If the token has an attribute called "action", set
                                 * the action attribute on the resulting form
                                 * element to the value of the "action" attribute of
                                 * the token. */
                                $attr = [];
                                $action = $this->getAttr($token, 'action');
                                if ($action !== false) {
                                    $attr[] = ['name' => 'action', 'value' => $action];
                                }
                                $this->emitToken([
                                    'name' => 'form',
                                    'type' => HTML5_Tokenizer::STARTTAG,
                                    'attr' => $attr
                                ]);

                                /* Act as if a start tag token with the tag name "hr" had
                                been seen. */
                                $this->emitToken([
                                    'name' => 'hr',
                                    'type' => HTML5_Tokenizer::STARTTAG,
                                    'attr' => []
                                ]);

                                /* Act as if a start tag token with the tag name "label"
                                had been seen. */
                                $this->emitToken([
                                    'name' => 'label',
                                    'type' => HTML5_Tokenizer::STARTTAG,
                                    'attr' => []
                                ]);

                                /* Act as if a stream of character tokens had been seen. */
                                $prompt = $this->getAttr($token, 'prompt');
                                if ($prompt === false) {
                                    $prompt = 'This is a searchable index. '.
                                    'Insert your search keywords here: ';
                                }
             