
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('UserModel');
    }

    public function show(){
        // Get current page (default 1)
        $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        // Get search query (optional)
        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 5; // number of users per page

        // Call model's pagination method
        $all = $this->UserModel->page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows = $all['total_rows'];

        // Configure pagination
        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('tailwind'); // themes: bootstrap, tailwind, custom
        $this->pagination->initialize($total_rows, $records_per_page, $page, site_url('users/show').'?q='.$q);

        // Send data to view
        $data['page'] = $this->pagination->paginate();
        $this->call->view('show', $data);
    }

    public function create() {
        if($this->io->method() == 'post'){
            $lastname = $this->io->post('last_name');
            $firstname = $this->io->post('first_name');
            $email = $this->io->post('email');
            $data = array(
                'last_name' => $lastname,
                'first_name' => $firstname,
                'email' => $email
            );
            if($this->UserModel->insert($data)){
                redirect('users/show');
            } else {
                echo 'Something went wrong';
            }
        } else {
            $this->call->view('create');
        }
    }

    public function update($id) {
        $data['user'] = $this->UserModel->find($id);
        if($this->io->method() == 'post'){
            $lastname = $this->io->post('last_name');
            $firstname = $this->io->post('first_name');
            $email = $this->io->post('email');
            $data = array(
                'last_name' => $lastname,
                'first_name' => $firstname,
                'email' => $email
            );
            if($this->UserModel->update($id, $data)){
                redirect('users/show');
            } else {
                echo 'Something went wrong';
            }
        } else {
            $this->call->view('update', $data);
        }
    }

    public function delete($id){
        if($this->UserModel->delete($id)){
            redirect('users/show');
        } else {
            echo 'Something went wrong';
        }
    }
}
