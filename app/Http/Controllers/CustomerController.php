<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Customer::query();

        $query->whereFilters($request->only(['search', 'filter']));

        //$query->whereSearch($request->get('search'));

        $query->withLastInteraction();

        $customers = $query->paginate(10)->withQueryString()->through(fn($customer) => [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,            
            'photo' => 'https://ui-avatars.com/api/?name='.$customer->first_name.' '.$customer->last_name,
            'company' => $customer->company->name,
            'birth_date' => Carbon::parse($customer->birth_date)->format('d-m-Y'),
            'last_interaction_date' => $customer->lastInteraction->created_at->diffForHumans(),
            'last_interaction_type' => $customer->lastInteraction->type,
        ]);

        //dd($customers);
        

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
            'search' => $request->get('search') ?? '',
            'filter' => $request->get('filter') ?? '',
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
