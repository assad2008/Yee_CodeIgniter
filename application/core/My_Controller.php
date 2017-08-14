<?php
/**
 * @file My_Controller.php
 * @synopsis  核心控制器重写
 * @author Yee, <rlk002@gmail.com>
 * @version 1.0
 * @date 2017-7-20 14:46:29
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class My_Controller extends CI_Controller
{

    public $db;
    public $base_url;
    public $view;

    public function __construct()
    {
        parent::__construct();
        $this->__init__();
    }

    private function __init__()
    {
        $this->db = $this->load->database('default', true);
        $this->load->driver('cache', array('adapter' => 'file'));
        $this->_view();
        $this->base_url = base_url();
        $this->view->assign('base_url', $this->base_url);
        $this->view->assign('systime', date('r'));
        $this->ismobile = $this->ua->is_mobile;
    }

    private function _view()
    {
        $this->config->load("twig");
        $view_config = $this->config->item("twig");
        $view_dir = $view_config["view_dir"];
        $options = [
            "cache" => $view_config["view_cache"],
            "debug" => true,
            "charset" => "UTF-8",
        ];
        $params = ["view" => $view_dir, "options" => $options];
        $this->load->library('twig', $params);
        $this->view = $this->twig;
    }

    public function showmsg($messages, $url_forward = '', $second = 3)
    {
        if ($url_forward && empty($second)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $url_forward");
        } else {
            if ($url_forward) {
                $message = "<font color=\"red\" size=\"5\"><b>{$messages}</b></font><script>setTimeout(\"window.location.href ='$url_forward';\", " . ($second * 1000) . ");</script>";
            }
            $this->view->assign('msg', $message);
            $this->view->assign('second', $second);
            $this->view->assign('message', $messages);
            $this->view->assign('content', "<a href=\"$url_forward\">" . $messages . "</a>");
            $this->view->assign('gourl', $url_forward);
            $this->view->display('message.html');
        }
        exit();
    }
}

class Unlogined_Controller extends My_Controller
{

    public $userinfo;

    public function __construct()
    {
        parent::__construct();
        $this->loginstatus();
        $this->view->assign("userinfo", $this->userinfo);
    }

    private function loginstatus()
    {
        if (!$this->session->userdata('user_id')) {
            $this->userinfo = [];
        } else {
            $user_id = $this->session->userdata('user_id');
            $this->userinfo = $this->userm->get_user_by_id($user_id);
        }
    }
}

class Logined_Controller extends My_Controller
{

    public $userinfo;

    public function __construct()
    {
        parent::__construct();
        $this->_check_login();
        $this->view->assign("userinfo", $this->userinfo);
    }

    private function _check_login()
    {
        if (!$this->session->userdata('user_id')) {
            #TODO
        } else {
            $user_id = $this->session->userdata('user_id');
            $userinfo = $this->userm->get_user_by_id($user_id);
            if (!$userinfo) {
                $this->session->unset_userdata('user_id');
                #TODO
            }
            $this->userinfo = $userinfo;
        }
    }
}
