<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Events\ContactFormValid;

class ContactController extends Controller
{
	/**
	 * Get the validation rules that apply to the request.
	 */
	public function rules()
	{
		return [
			'name' => 'required',
			'email' => 'required|email',
			'msg_body' => 'required',
		];
	}

    public function getIndex()
    {
    	return view('contact.new');
    }

    public function postStore(ContactFormRequest $request)
    {
    	event(new ContactFormValid($request));
    	return back()
    		->with('message', 'Thanks for contacting us! Your message has been sent.');
    }
}
