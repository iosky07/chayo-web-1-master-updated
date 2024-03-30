<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Student;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home() {
        return view('pages.landing.menu.index');
    }

    public function login_form() {
        return view('auth.login');
    }

    public function about() {
        $member = Member::all();

        return view('pages.landing.menu.about', compact('member'));
    }

    public function blog() {
        return view('pages.landing.menu.blog');
    }

    public function singleBlog() {
        return view('pages.landing.menu.single-blog');
    }

    public function contact() {
        return view('pages.landing.menu.contact');
    }

    public function pointDetail($id) {
        $detail = Student::findOrFail($id);
        $p_detail = StudentDetail::whereStudentId($id)->get();
//        dd($p_detail);

        return view('pages.landing.menu.point-detail', compact('detail', 'p_detail'));
    }
}
