<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post') && $request->has('back')) {
            $contact = session('contact', []);
        } else {
            $contact = [];
        }

        $categories = Category::all();
        
        return view('index', compact('contact','categories'));
    }
    
    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['last_name', 'first_name','gender','email', 'tel1','tel2','tel3','address','building','category_id', 'content']);
        
        $contact['combinedName'] = $contact['last_name'] . ' ' . $contact['first_name'];
        $contact['combinedTel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];
        
        $category = Category::find($contact['category_id']);
        $contact['inquiry_type'] = $category ? $category->content : '';
        
        session(['contact' => $contact]);
        
        return view('confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        $contact = session('contact');

        if (!$contact) {
        return redirect('/')->with('error', 'セッションが切れました。');
        }


        $genderMap = [
            '男性' => 1,
            '女性' => 2,
            'その他' => 3
        ];

        Contact::create([
            'category_id' => $contact['category_id'],
            'first_name' => $contact['first_name'],
            'last_name' => $contact['last_name'],
            'gender' => $genderMap[$contact['gender']],
            'email' => $contact['email'],
            'tel' => $contact['combinedTel'],
            'address' => $contact['address'],
            'building' => $contact['building'],
            'detail' => $contact['content'],
        ]);

        session()->forget('contact');

        return view('thanks');

    }
}