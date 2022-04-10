<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */
	use ResponseTrait;
	public function before(RequestInterface $request, $arguments = null)
	{
		$req = \Config\Services::request();
		$uAgent = $req->getUserAgent();
		if ($req->getVar('android')) {
			$token = null;

			$header = $req->header('Authorization');
			// extract the token from the header
			if (!empty($header)) {
				if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
					$token = $matches[1];
				}
			}

			if (is_null($token) || empty($token)) {
				return $this->failUnauthorized();
			}

			$decoded = null;
			try {
				$decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
			} catch (Exception $e) {
				return $this->failUnauthorized();
			}
		} else {
			$id = session()->get('LoggedInID');
			if (empty($id)) {
				return redirect()->route('home')->with('info', [
					'judul' => 'User tidak Login',
					'msg' => 'Anda harus login terlebih dahulu sebelum mengakses url ini',
					'role' => 'error'
				]);
			}
			$uModel = new UserModel();
			$userData = $uModel->find($id);
			if (!empty($arguments)) {
				if (in_array('psi', $arguments) && $userData['role'] != 1) {
					return redirect()->route('admin.dashboard')->with('info', [
						'judul' => 'User tidak punya akses',
						'msg' => 'Anda tidak diijinkan mengakses url ini',
						'role' => 'error'
					]);
				}
				if (in_array('bagkeu', $arguments) && $userData['role'] != 2) {
					return redirect()->route('admin.dashboard')->with('info', [
						'judul' => 'User tidak punya akses',
						'msg' => 'Anda tidak diijinkan mengakses url ini',
						'role' => 'error'
					]);
				}
				if (in_array('yayasan', $arguments) && $userData['role'] != 3) {
					return redirect()->route('admin.dashboard')->with('info', [
						'judul' => 'User tidak punya akses',
						'msg' => 'Anda tidak diijinkan mengakses url ini',
						'role' => 'error'
					]);
				}
			}
		}
	}

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
