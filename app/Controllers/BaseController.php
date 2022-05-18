<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	protected $userdata;

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		// $this->userdata = null;
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$uModel = new UserModel();
		// if (\Config\Services::request()->getPost('android')) {
		$header = \Config\Services::request()->header('Authorization');
		// if (!empty($header)) return \Config\Services::response()->setJSON([
		// 	'header' => $header
		// ])->setStatusCode(200);
		$jwt = null;
		if (!empty($header)) {
			if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
				$jwt = $matches[1];
			}
		}
		// print_r("Bruh");
		$this->userdata = $uModel->find(session()->get('LoggedInID'));
		$id = null;
		if ($jwt != null) {
			try {

				$decoded = JWT::decode($jwt, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
				$id = $decoded->id_user;

				$this->userdata = $uModel->find($id);
			} catch (Exception $ex) {
				//throw $th;
			}
		}
		// d($this->userdata);
		// } else {
		// if (!empty(session()->get('LoggedInID')))
		// }

		$this->breadcrumbs[] = [
			'namelink' => 'Sistem Informasi Inventaris Barang',
			'link' => base_url() . route_to('admin.dashboard'),
		];

		$this->keyAjax = password_hash('SIIBMantap', PASSWORD_BCRYPT);
	}

	public function SetSessionAjaxReq()
	{
		helper('text');
		$var = random_string('alnum', 16);
		session()->set('SessionAjax', $var);
		return $var;
	}
	public function DelSessionAjaxReq()
	{
		session()->remove('SessionAjax');
	}
}
