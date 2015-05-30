<?php namespace App\Http\Controllers;

use App\Company;
use App\Movement;
use App\Ship;
use App\Stop;
use Illuminate\Http\Request;

class StatsController extends Controller {

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
		$this->middleware('agent');
	}

    /**
     * Show the application dashboard to the user.
     *
     * @param Request $req
     * @return Response
     */
	public function quantityOnMonth(Request $req)
	{

        $companies = [0 => 'Toutes'];
        foreach (Company::all() as $company) {
            $companies[$company->id] = $company->name;
        }

        $months = [];
        foreach (Stop::select('date_in')->get() as $stop) {
            $date = $stop->getDateIn()->format('Y-m');
            if (!array_key_exists($date, $months))
                $months[$date] = $stop->getDateInShortString();
        }

        $ships = [0 => 'Tout'];
        foreach (Ship::all() as $ship) {
            $ships[$ship->id] = $ship->name;
        }

        if ($req->get('ship', 0) > 0) {
            $stops = [0 => 'Toutes'];
            foreach (Stop::where('ship_id', $req->get('ship'))->get() as $stop) {
                $stops[$stop->id] = strval($stop);
            }
        } else {
            $stops = [];
        }

        if ($req->has('month')) {
            $items = Stop::where('date_in', 'LIKE', $req->get('month') . '%')->get();
            if ($req->get('company', 0) > 0) {
                $company_id = $req->get('company');
                $items = $items->filter(function ($item) use ($company_id) {
                    return ($item->ship->company->id == $company_id);
                });
            }
            if ($req->get('ship', 0) > 0) {
                $ship_id = $req->get('ship');
                $items = $items->filter(function ($item) use ($ship_id) {
                    return ($item->ship->id == $ship_id);
                });
            }
            if ($req->get('stop', 0) > 0) {
                $stop_id = $req->get('stop');
                $items = $items->filter(function ($item) use ($stop_id) {
                    return ($item->id == $stop_id);
                });
            }
            $results = [];
            foreach ($items as $item) {
                if (!array_key_exists(strval($item->ship->company), $results))
                    $results[strval($item->ship->company)] = [];
                if (!array_key_exists(strval($item->ship), $results[strval($item->ship->company)]))
                    $results[strval($item->ship->company)][strval($item->ship)] = [];

                $results[strval($item->ship->company)][strval($item->ship)] = [
                    'chargement' => Movement::where('stop_id', $item->id)->where('type', 'C')->count(),
                    'dechargement' => Movement::where('stop_id', $item->id)->where('type', 'D')->count(),
                ];
            }
//            dd($results);
        } else
            $results = [];

        return view('stats.quantityOnMonth', compact('companies', 'months', 'ships', 'stops', 'results'));
	}
	public function quantityOnMonth_client(Request $req)
	{

        $clients = [0 => 'Toutes'];
        foreach (Client::all() as $client) {
            $clients[$client->id] = $client->name;
        }

        $months = [];
        foreach (Stop::select('date_in')->get() as $stop) {
            $date = $stop->getDateIn()->format('Y-m');
            if (!array_key_exists($date, $months))
                $months[$date] = $stop->getDateInShortString();
        }

        $ships = [0 => 'Tout'];
        foreach (Ship::all() as $ship) {
            $ships[$ship->id] = $ship->name;
        }

        if ($req->get('ship', 0) > 0) {
            $stops = [0 => 'Toutes'];
            foreach (Stop::where('ship_id', $req->get('ship'))->get() as $stop) {
                $stops[$stop->id] = strval($stop);
            }
        } else {
            $stops = [];
        }

        if ($req->has('month')) {
            $items = Stop::where('date_in', 'LIKE', $req->get('month') . '%')->get();
            if ($req->get('client', 0) > 0) {
                $client_id = $req->get('client');
                $items = $items->filter(function ($item) use ($client_id) {
                    return ($item->client->id == $client_id);
                });
            }
            if ($req->get('ship', 0) > 0) {
                $ship_id = $req->get('ship');
                $items = $items->filter(function ($item) use ($ship_id) {
                    return ($item->ship->id == $ship_id);
                });
            }
            if ($req->get('stop', 0) > 0) {
                $stop_id = $req->get('stop');
                $items = $items->filter(function ($item) use ($stop_id) {
                    return ($item->id == $stop_id);
                });
            }
            $results = [];
            foreach ($items as $item) {
                if (!array_key_exists(strval($item->ship->company), $results))
                    $results[strval($item->ship->company)] = [];
                if (!array_key_exists(strval($item->ship), $results[strval($item->ship->company)]))
                    $results[strval($item->ship->company)][strval($item->ship)] = [];

                $results[strval($item->ship->company)][strval($item->ship)] = [
                    'chargement' => Movement::where('stop_id', $item->id)->where('type', 'C')->count(),
                    'dechargement' => Movement::where('stop_id', $item->id)->where('type', 'D')->count(),
                ];
            }
//            dd($results);
        } else
            $results = [];

        return view('stats.quantityOnMonth', compact('clients', 'months', 'ships', 'stops', 'results'));
	}

}
