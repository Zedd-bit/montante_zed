<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 * @link https://github.com/ronmarasigan/LavaLust
 */

class Invoker {
    public $properties = [];

    public function __set($prop, $val) {
        $this->properties[$prop] = $val;
    }

    public function __get($prop) {
        if (array_key_exists($prop, $this->properties)) {
            return $this->properties[$prop];
        } else {
            throw new Exception("Property $prop does not exist");
        }
    }

    private $class;
    private $sub_dir = '';

    private function get_sub_dir($url) {
        if(strpos($url, '/')) {
            $model = explode('/', $url);
            $this->class = end($model);
            array_pop($model);
            $this->sub_dir = '/' . implode('/', $model);
        } else {
            $this->class = $url;
        }
    }

    public function model($class, $object_name = NULL)
    {
        if( ! class_exists('Model')) {
            require_once(SYSTEM_DIR.'kernel/Model.php');
        }

        $LAVA = lava_instance();

        if(is_array($class))
        {
            foreach($class as $key => $value)
            {
                $this->get_sub_dir($value);
                if(! is_int($key))
                {
                    $LAVA->properties[$key] = load_class($this->class, 'models' . $this->sub_dir, NULL, $key);
                } else {
                    $LAVA->properties[$this->class] = load_class($this->class, 'models' . $this->sub_dir, NULL, $this->class);
                }
            }
        } else {
            $this->get_sub_dir($class);
            if(! is_null($object_name))
            {
                $LAVA->properties[$object_name] = load_class($this->class, 'models' . $this->sub_dir, NULL, $object_name);
            } else {
                $LAVA->properties[$this->class] = load_class($this->class, 'models' . $this->sub_dir);
            }
        }
    }

    public function view($view_file, $data = NULL)
    {
        $LAVA = lava_instance();
        foreach (get_object_vars($LAVA) as $key => $val)
        {
            if ( ! isset($this->properties[$key]))
            {
                $this->properties[$key] = $LAVA->$key;
            }
        }

        if(! is_null($data)) {
            $page_vars = array();
            if(is_array($data))
            {
                foreach($data as $key => $value)
                {
                    $page_vars[$key] = $value;
                }
            } elseif(is_string($data))
            {
                $page_vars[$data] = $data;
            } else {
                throw new RuntimeException('View parameter only accepts array and string types');
            }
            extract($page_vars, EXTR_SKIP);
        }
        ob_start();
        $view = APP_DIR .'views' . DIRECTORY_SEPARATOR . $view_file;
        if(strpos($view_file, '.') === false)
        {
            if(file_exists($view . '.php'))
            {
                require_once($view . '.php');
            } else {
                throw new RuntimeException($view_file . ' view file did not exist.');
            }
        } else {
            if(file_exists($view))
            {
                require_once($view);
            } else {
                throw new RuntimeException($view_file . ' view file does not exist.');
            }
        }
        echo ob_get_clean();
    }

    public function helper($helper)
    {
        if ( is_array($helper) ) {
            foreach( array(APP_DIR . 'helpers', SYSTEM_DIR . 'helpers') as $dir )
            {
                foreach( $helper as $hlpr )
                {
                    if ( file_exists($dir . DIRECTORY_SEPARATOR . $hlpr . '_helper.php') ) {
                        require_once $dir . DIRECTORY_SEPARATOR . $hlpr . '_helper.php';
                    }
                }
            }
        } else {
            foreach( array(APP_DIR . 'helpers', SYSTEM_DIR . 'helpers') as $dir )
            {
                if ( file_exists($dir . DIRECTORY_SEPARATOR . $helper . '_helper.php') )
                {
                    require_once $dir . DIRECTORY_SEPARATOR . $helper . '_helper.php';
                }
            }
        }
    }

    public function library($classes, $params = NULL)
    {
        $LAVA = lava_instance();
        if(is_array($classes))
        {
            foreach($classes as $class)
            {
                if($class == 'database') {
                    $database = load_class('database', 'database');
                    $LAVA->db = $database::instance(NULL);
                }
                $LAVA->properties[$class] = load_class($class, 'libraries');
            }
        } else {
            $LAVA->properties[$classes] = load_class($classes, 'libraries', $params);
        }
    }

    public function database($dbname = NULL)
    {
        $LAVA = lava_instance();
        $database = load_class('database','database', $dbname);
        if(is_null($dbname)) {
            $LAVA->db = $database::instance(NULL);
        } else {
            $LAVA->properties[$dbname] = $database::instance($dbname);
        }
    }

    public function dbforge()
    {
        $LAVA = lava_instance();
        $LAVA->properties['dbforge'] = load_class('dbforge','database');
    }

    public function initialize()
    {
        $autoload = autoload_config();

        if(count($autoload['libraries']) > 0)
        {
            $this->library($autoload['libraries']);
        }
        if(count($autoload['models']) > 0)
        {
            $this->model($autoload['models']);
        }
        if(count($autoload['helpers']) > 0)
        {
            $this->helper($autoload['helpers']);
        }
        if(count($autoload['configs']) > 0)
        {
            lava_instance()->config->load($autoload['configs']);
        }
    }
}
