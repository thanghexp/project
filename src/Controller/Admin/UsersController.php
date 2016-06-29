<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

use Cake\ORM\TableRegistry;

class UsersController extends AppController {

	public function initializie() {
		parent::initializie();
		 $this->Auth->allow(['login', 'register']);

		$this->loadComponent('AkkaFacebook.Graph', [
	        'app_id' => '1749197665350898',
	        'app_secret' => '270ebc5f68ac70bfe8808c3bc8dd234e',
	        'app_scope' => 'email,public_profile', // https://developers.facebook.com/docs/facebook-login/permissions/v2.4
	        'redirect_url' => Router::url(['controller' => 'Users', 'action' => 'login'], TRUE), // This should be enabled by default
	        'post_login_redirect' => '' //ie. Router::url(['controller' => 'Users', 'action' => 'account'], TRUE)
	        // 'user_columns' => ['first_name' => 'fname', 'last_name' => 'lname', 'username' => 'uname', 'password' => 'pass'] //not required
	    ]);
	}

	public function login() 
	{
		$usersTable = TableRegistry::get('users');
		$user = $usersTable->newEntity();

		if($this->request->is('POST')) {
			$user = $this->Auth->identify();

			if($user) {
				$this->Auth->setUser($user);

				$this->Flash->success(__('Login succcess !')); 
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Flash->error(__('Login fail !'));
			}
		}
	}

	public function register()
	{
		$usersTable = TableRegistry::get('users');
		$user = $usersTable->newEntity();

		if($this->request->is('POST')) {
			$data = $this->request->data();
			// $data['salt'] = rand(255);
			// echo $data['salt']; die;
			// $data['password'] = md5(md5($data['password']) . md5($data['salt']));
 			// 	echo $data['password']; die;
			$user = $usersTable->patchEntity($user, $data);

			if($usersTable->save($user)) {
				// $this->redirect(['controller' => 'users', 'action' => 'login']);
				$this->Flash->success(__('Create new success'));
			} else {
				$this->Flash->error(__('Error create new'));
			}
		}

		$this->set('user', $user);
	}

	public function isAuthorized($user)
	{
		if( !$user) {
			$this->Flash->error(__('You still login yet !'));
			$this->redirect(['contrller' => 'admin']);
		}
		return true;
	}

	public function updateInfo()
	{
		$user = $this->Auth->user();

		$usersTable = TableRegistry::get('users');
		
		$user = $usersTable->newEntity($user, ['validate' => 'UpdateInfo']);
		if( $this->request->is('POST') ) {

			$data = $this->request->data();

			$data['username'] = $user->username;
			$data['user_id'] = $user->user_id;
			$user = $usersTable->patchEntity($user, $data, ['validate' => 'UpdateInfo'] );

			if( !$user->errors ) {
				if($usersTable->save( $user )) {
					$this->Auth->setUser($data);

					$this->redirect( ['controller' => 'home', 'action' => 'index'] );
					$this->Flash->success(__('Update info success'));
				} 
			} else {
				$this->Flash->error(__('Error create new'));
			}
			
		}
		$this->set('user', $user);
	}

	public function changePassword() 
	{
		$user = $this->Auth->user();

		$usersTable = TableRegistry::get( 'users' );
		$user = $usersTable->newEntity( $user, ['validate' => false] );

		if( $this->request->is("POST") ) {
			$data = $this->request->data();

			if( $data['new_password'] == $data['confirm_password'] ) {
				$user = $usersTable->patchEntity( $user, $data, ['validate' => false] );
				$user->password = $data['new_password'];

				if( $usersTable->save( $user ) ) {
					$this->redirect(['controller' => 'home', 'action' => '']);
					$this->Flash->success(__('Change Password success !'));
				} else {
					$this->Flash->error(__('Error data'));
				}

			} else {
				$this->Flash->error(__('Confirm password not same New password !'));
			}

		}	

	}

	public function logout(){	
		return $this->redirect($this->Auth->logout());
	}

	public function listUser() 
	{
		$usersTable = TableRegistry::get('users');
		$users = $usersTable->find('all');

		if($this->request->is('POST')) {
			$data = $this->request->data();	

			foreach($data['status'] as $key => $value) {
				$user = $usersTable->find('all')->where(['user_id' => $key])->first();
				$user->status = (int) $value;
				$usersTable->save($user); 
			}

		}

		if(!$users) {
			$this->Flash->error(__('Database category table empty !'));
		}
		
		$dropdown = ['0' => 'Online', '1' => 'Block'];

		$this->set('dropdown', $dropdown);
		$this->set('users', $this->paginate($users));
		$this->set('title', 'Manage users');
	}

	public function deleteUser ($user_id) {
		$usersTable =TableRegistry::get('users');
		$user = $usersTable->find('all')->where(['user_id' => $user_id])->first();

		if($user) {
			if($usersTable->delete($user)) {
				$this->Flash->success(__('Delete success !'));
			} else {
				$this->Flash->error(__('Can \' delete this user !'));
			}
		}
		return $this->redirect(['controller' => 'users', 'action' => 'listUser']);
	}

}