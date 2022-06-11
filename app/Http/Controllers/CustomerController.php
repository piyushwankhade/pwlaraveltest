<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
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

        $query->with('company');
        
        $query->withLastInteraction();

        $query->whereFilters($request->only(['search', 'filter']));

        if ($request->order && $request->dir) {
            $query->orderByField($request->only(['order','dir']));            
        }

        $query->visibleTo(auth()->user()); 

        $customers = $query->latest()->paginate(10)->withQueryString()->through(fn($customer) => [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,            
            'photo' => 'https://ui-avatars.com/api/?name='.$customer->first_name.' '.$customer->last_name,
            'company' => $customer->company->name,
            'birth_date' => Carbon::parse($customer->birth_date)->format('Y-m-d'),
            'last_interaction_date' => $customer->lastInteraction ? $customer->lastInteraction->created_at->diffForHumans() : '-',
            'last_interaction_type' => $customer->lastInteraction ? $customer->lastInteraction->type : '',
        ]);

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
            'search' => $request->get('search') ?? '',
            'filter' => $request->get('filter') ?? '',
            'order' => $request->get('order') ?? '',
            'dir' => $request->get('dir') ?? ''
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Customers/Create',[
            'users' => User::select('id','name')->get(),
            'companies' => Company::select('id','name')->get(),            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',            
            'birth_date' => 'required|date_format:Y-m-d',
            'sales_rep_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        Customer::create($validatedData);

        return redirect()->route('customers.index');
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
        return Inertia::render('Customers/Edit',[
            'customer' => $customer,
            'users' => User::select('id','name')->get(),
            'companies' => Company::select('id','name')->get(),            
        ]);
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
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',            
            'birth_date' => 'required|date_format:Y-m-d',
            'sales_rep_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        $customer->update($validatedData);

        return redirect()->route('customers.index');
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
