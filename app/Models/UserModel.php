<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class UserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id_user';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'id_user', 'nama_user', 'username', 'password', 'role'
	];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';


	protected $column_order = array(null, 'nama', 'username', 'role', null);
	protected $column_search = array('nama', 'username');
	protected $order = array('id_user' => 'asc');

	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest
	 */
	protected $request;
	protected $db;
	protected $dt;

	function __construct(RequestInterface $request = null)
	{
		parent::__construct();
		$this->db = db_connect();
		$this->request = $request;

		$this->dt = $this->db->table($this->table);
	}

	// public function setDateLogin($id)
	// {
	// 	$this->update($id, [
	// 		'lastlogin' => Time::now()
	// 	]);
	// }

	public function getDataUser($id)
	{
		return $this->find($id);
	}

	private function _get_datatables_query()
	{
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($this->request->getPost('search')['value']) {
				if ($i === 0) {
					$this->dt->groupStart();
					$this->dt->like($item, $this->request->getPost('search')['value']);
				} else {
					$this->dt->orLike($item, $this->request->getPost('search')['value']);
				}
				if (count($this->column_search) - 1 == $i)
					$this->dt->groupEnd();
			}
			$i++;
		}

		if ($this->request->getPost('order')) {
			$this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->dt->orderBy(key($order), $order[key($order)]);
		}
	}
	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($this->request->getPost('length') != -1)
			$this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
		$query = $this->dt->get();
		return $query->getResult();
	}
	function count_filtered()
	{
		$this->_get_datatables_query();
		return $this->dt->countAllResults();
	}
	public function count_all()
	{
		$tbl_storage = $this->db->table($this->table);
		return $tbl_storage->countAllResults();
	}
}
