<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PLS_Lang extends CI_Lang
{
    private $languages;
    private $lang_uri;
    public $default_lang;
    private $hide_default_lang;

    function __construct()
    {
        parent::__construct();

        global $URI, $CFG, $IN;

        $config =& $CFG->config;
        $CFG->load('language');

        /* get default language */
        $this->default_lang  = $config['language'];

        /* get available site languages */
        $this->languages = $CFG->item('site_languages');

        /* get rule to hide default language on url or not */
        $this->hide_default_lang = $CFG->item('hide_default_lang');;

        /* get the language from uri */
        $this->lang_uri = $URI->segment(1);


        if (strlen($this->lang_uri) == 2) {
            if ($this->lang_uri == $this->default_lang && $this->hide_default_lang) {
                $URI->uri_string = preg_replace("|^\/?$this->lang_uri|", '', $URI->uri_string);
                header('Location: '.$URI->uri_string);
                exit;
            }
            else {
               if ($this->lang_exists($this->lang_uri)) {

                    /* set config language values to match the user language */
                    $config['language'] = $this->lang_uri;

                    /* reset the index_page value */
                    $config['base_url'] .= $this->lang_uri.'/';

                    /* reset uri segments and uri string */
                    array_unshift($URI->segments, '');
                    array_shift($URI->segments);

                    /* set the language cookie */
                    $IN->set_cookie('user_lang', $this->lang_uri, 43200);
               }
               else {
                    /* remove invalid lang uri */
                    $URI->uri_string = preg_replace("|^\/?$this->lang_uri|", '', $URI->uri_string);

                    /* redirect */
                    header('Location: '.$URI->uri_string);
                    exit;
                }
            }
        }
    }


    /**
     * Get current language
     * @return mixed
     */
    function get_current_lang() {
        return ($this->lang_exists($this->lang_uri) ? $this->lang_uri : $this->default_lang);
    }


    /**
     * Get clean uri without language segment
     * @return string|void
     */
    function get_clean_uri() {
        if($this->lang_exists($this->lang_uri)) {
            return preg_replace("|^\/?$this->lang_uri|", '', uri_string());
        }
    }


    /**
     * Get uri string with language segment
     * @param $language_segment
     * @param bool $uri
     * @return bool|string|void
     */
    function get_uri($lang_uri, $uri = FALSE) {
        $uri = ($uri === FALSE) ? $this->get_clean_uri() : trim($uri, '/');

        if(!$this->lang_exists($lang_uri)) {
            return $uri;
        }

        if($lang_uri == $this->default_lang AND $this->hide_default_lang === TRUE) {
            return $uri;
        }

        $uri = $lang_uri.'/'.$uri;

        return $uri;
    }


    /**
     * Change uri lang segment
     * @param bool $language
     * @return array|bool|string|void
     */
    function change_uri_lang($language = false) {
        if($language == false) {
            $uris = array();
            foreach($this->languages as $item) {
                $uris[] = $this->get_uri($item);
            }
            return $uris;
        }

        if( ! $this->lang_exists($language)) {
            return '';
        }

        return $this->get_uri($language);
    }


    /**
     * Check language exists or note
     * Finds by language_code
     * @return  bool if exists return TRUE else FALSE
     **/
    public function lang_exists($language_code)
    {
        if(in_array($language_code, $this->languages))
            return TRUE;
        else
            return FALSE;
    }


    /**
     * Get language bar
     * @return string
     */
    function get_lang_bar() {
        $ci = & get_instance();
        $html = '';

        foreach($this->languages as $item) {
            $uri = $this->get_uri($item);

            $row = ($item != $this->get_current_lang()) ? anchor($uri, $item, 'title="'.$item.'"') : $item;

            $html .= sprintf($ci->config->item('language_item_wrapper'), $row);
        }

        return sprintf($ci->config->item('language_wrapper'), $html);
    }
}
