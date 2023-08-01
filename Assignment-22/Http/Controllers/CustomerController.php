<?php

// app/Http/Controllers/CustomerController.php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Fetch all customers from the database and pass them to the view.
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        // Show the form to create a new customer.
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validate the request data and create a new customer record in the database.
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers',
            'contact_number' => 'required|string',
            // Add other validation rules for other columns.
        ]);

        Customer::create($validatedData);

        return redirect()->route('customers.index')
            ->with('success', 'Customer added successfully!');
    }

    public function show(Customer $customer)
    {
        // Show the details of a specific customer.
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        // Show the form to edit a customer's details.
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // Validate the request data and update the customer record in the database.
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'contact_number' => 'required|string',
            // Add other validation rules for other columns.
        ]);

        $customer->update($validatedData);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        // Delete a customer record from the database.
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
