<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller {
	public function indexAction() {

	}

	public function registerAction() {
		$user = new Users();

		$success = $user->save(
			$this->request->getPost(),
			[
				'name',
				'email',
			]
		);

		if ($success) {
			echo "Thanks for registering!";
		} else {
			echo "Sorry, the following problems were generated: ";

			$messages = $user->getMessages();

			foreach ($messages as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}

		$this->view->disable();
	}

	// should not in this controller. learning purpose only
	public function usersAction() {
		$users = Users::find();
		$this->view->users = $users;
	}

	// should not in this controller. learning purpose only
	public function editAction($id) {
		$data = $this->request->getPost();
		if (!empty($data)) {
			$user = Users::findFirst(intval($data['id']));
			$user->name = $data['name'];
			$user->email = $data['email'];
			$this->view->success = $user->save();
			if (!$this->view->success) {
				$this->view->messages = $user->getMessages();
			}
		}
		$user = Users::findFirst(intval($id));
		$this->view->user = $user;
	}

	// should not in this controller. learning purpose only
	public function deleteAction($id) {
		$user = Users::findFirst(intval($id));
		if (!$user) {
			echo 'User doesnt exist';
		}

		$success = $user->delete();

		if (!$success) {
			echo "Sorry, we can't delete the user right now: <br/>";

			$messages = $user->getMessages();

			foreach ($messages as $message) {
				echo $message, "<br/>";
			}
		}

		echo "User was deleted";
	}
}
