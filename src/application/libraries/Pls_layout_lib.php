<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PLS_Layout_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Landing Main Layout
     * @param string $view View
     * @param array $params Params
     * @param string $layout Layout
     */
    public function landing_layout($view, $params = [], $layout = 'main')
    {
        $params['language_bar'] = $this->CI->lang->get_lang_bar();
        $params['current_lang'] = $this->CI->lang->get_current_lang();

        // Load the view's content, with the params passed
        $view_content = $this->CI->load->view($view, $params, TRUE);

        $data = [
            'page_title' => (isset($params['page_title']))?$params['page_title']:'',
            'content' => $view_content
        ];
        // Load the layout and render view
        $this->CI->load->view('layouts/landing/' . $layout, $data);
    }


    /**
     * Partner Auth Layout
     * @param string $view View
     * @param array $params Params
     * @param string $layout Layout
     */
    public function auth_layout($view, $params = [], $layout = 'auth')
    {
        $params['current_lang'] = $this->CI->lang->get_current_lang();

        // Load the view's content, with the params passed
        $view_content = $this->CI->load->view($view, $params, TRUE);

        $data = [
            'page_title' => (isset($params['page_title']))?$params['page_title']:'',
            'content' => $view_content
        ];
        // Load the layout and render view
        $this->CI->load->view('layouts/' . $layout, $data);
    }

    /**
     * Partner Layout
     * @param string $view View
     * @param array $params Params
     * @param string $layout Layout
     */
    public function admin_layout($view, $params = [], $layout = 'main')
    {
        // Load the view's content, with the params passed
        $view_content = $this->CI->load->view($view, $params, TRUE);

        $data = [
            'page_title' => (isset($params['page_title']))?$params['page_title']:'',
            'content' => $view_content
        ];
        // Load the layout and render view
        $this->CI->load->view('layouts/admin/' . $layout, $data);
    }

    /**
     * Partner Layout
     * @param string $view View
     * @param array $params Params
     * @param string $layout Layout
     */
    public function partner_layout($view, $params = [], $layout = 'main')
    {
        // Load the view's content, with the params passed
        $view_content = $this->CI->load->view($view, $params, TRUE);

        $data = [
            'page_title' => (isset($params['page_title']))?$params['page_title']:'',
            'content' => $view_content
        ];
        // Load the layout and render view_content
        $this->CI->load->view('layouts/student/' . $layout, $data);
    }


    /**
     * Errors Layout
     * @param string $view View
     * @param array $params Params
     */
    public function errors_layout($view, $params = [])
    {
        // Load the view's content, with the params passed
        $view_content = $this->CI->load->view($view, $params, TRUE);

        $data = [
            'page_title' => (isset($params['page_title']))?$params['page_title']:'',
            'content' => $view_content
        ];
        // Load the layout and render view_content
        return $this->CI->load->view('layouts/errors', $data, TRUE);
    }

}
