<?php

class Xhgui_Controller_Watch
{

    protected $_app;
    protected $_watches;

    public function __construct($app, $watches)
    {
        $this->_app = $app;
        $this->_watches = $watches;
    }

    public function get($server)
    {
        $watched = $this->_watches->getAll($server);

        $this->_app->render('watch/list.twig', array(
            'watched' => $watched,
            'server'  => $server
        ));
    }

    public function post($server)
    {
        $app = $this->_app;
        $watches = $this->_watches;

        $saved = false;
        $request = $app->request();
        foreach ((array)$request->post('watch') as $data) {
            $saved = true;
            $watches->save($data, $server);
        }
        if ($saved) {
            $app->flash('success', 'Watch functions updated.');
        }
       // $app->redirect($app->urlFor('watch.list', array('server' => $server)));
    }
}
