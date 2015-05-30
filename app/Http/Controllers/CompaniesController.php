<?php namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;

class CompaniesController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('agent', ['except' => [
            'detail'
        ]]);
	}

    public static function routes($router)
    {
        $router->pattern('company_id', '[0-9]+');

        $router->get('/', ['uses' => 'CompaniesController@index',
            'as' => 'companies.index']);

        $router->get('/nouveau', ['uses' => 'CompaniesController@add',
            'as' => 'companies.add']);

        $router->post('/nouveau', 'CompaniesController@create');

        $router->get('/{company_id}/modifier', ['uses' => 'CompaniesController@edit',
            'as' => 'companies.edit']);

        $router->post('/{company_id}/modifier', 'CompaniesController@update');

        $router->get('/{company_id}/supprimer', ['uses' => 'CompaniesController@delete',
            'as' => 'companies.delete']);

        $router->get('/{company_id}', ['uses' => 'CompaniesController@detail',
            'as' => 'companies.detail']);
    }

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$companies = Company::paginate(15);
        return view('companies.index', compact('companies'));
	}

    public function add(Request $req)
    {
        $company = new Company();
        return view('companies.form', compact('company'));
    }

    public function create(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $company = new Company($req->all());

        $user = new User();
        $user->name = $company->name;
        $user->email = $req->get('email');
        $user->password = $req->get('password');
        $user->type = 'CO';
        $user->save();
        $company->user_id = $user->id;
        $company->save();

        $req->session()->flash('success', "La compagnie $company a bien été créée.");

        return redirect()->route('companies.index');
    }

    public function edit($company_id)
    {
        $company = Company::findOrFail($company_id);
        return view('companies.form', compact('company'));
    }

    public function update($company_id, Request $req)
    {
        $company = Company::findOrFail($company_id);
        $this->validate($req, [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'email' => 'required|email|unique:users,id,'.$company_id,
        ]);

        $company->fill($req->all());

        $company->user->name = $company->name;
        $company->user->email = $req->get('email');
        $company->user->save();
        $company->save();

        $req->session()->flash('success', "La compagnie $company a bien été modifiée.");

        return redirect()->route('companies.index');
    }

    public function delete($company_id, Request $req)
    {
        $company = Company::findOrFail($company_id);
        $company->user->delete();
        $company->delete();

        $req->session()->flash('success', "La compagnie $company a bien été supprimée.");
        return redirect()->route('companies.index');
    }

    public function detail($company_id, Request $req, Guard $auth)
    {
        if ($auth->user()->type == 'CL' || ($auth->user()->type == 'CO' && $company_id != $auth->user()->company->id))
            abort(403, "Non autorisé");

        $company = Company::findOrFail($company_id);

        return view('companies.detail', compact('company'));
    }

}
