<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Models\M_ticket;

class C_pages extends Controller
{
    protected $base_url = "";
    protected $breadcrumb = [];
    public function __construct(){
      $this->base_url = url('/');
      $full_url = Request::fullUrl();
      $full_url = explode("/",$full_url);
      array_push($this->breadcrumb, array("url" =>$this->base_url, "text" => 'Dashboard'));
      for($i = 3; $i < count($full_url); $i++){
        $this->base_url = $this->base_url."/".$full_url[$i];
        array_push($this->breadcrumb, array(
          'text' => strtoupper(substr($full_url[$i], 0, 1)).substr($full_url[$i], 1),
          'url' => $this->base_url,
        ));
      }
    }


    private function child_menu($menu, $id){
      $list_child = [];
      foreach ($menu as $key) {
        if($id == $key->parent){
          $data = [];
          $data['id'] = $key->id;
          $data['menu'] = $key->menu;
          $data['link'] = $key->link;
          $data['icon'] = $key->icon;
          $data['active'] = $key->active;
          $data['parent'] = $key->parent;
          $data['class'] = $key->class;
          $data['child'] = $this->child_menu($menu, $key->id);
          array_push($list_child, $data);
        }
      }
      return $list_child;
    }
  
    private function getTrustee(){
      if(Request::get('menu') !== null){
        $list_menu = [];
        $menu = Request::get('menu');
        foreach ($menu as $key) {
          if($key->parent == null){
            $data = [];
            $data['id'] = $key->id;
            $data['menu'] = $key->menu;
            $data['link'] = $key->link;
            $data['icon'] = $key->icon;
            $data['active'] = $key->active;
            $data['parent'] = $key->parent;
            $data['class'] = $key->class;
            $data['child'] = $this->child_menu($menu, $key->id);
            array_push($list_menu, $data);
          }
        }
        return $list_menu;
      }
      return [];
    }
  
    public function returnTemplate($title = "", $data = []){
      $resp = [];
      $resp = [
        'menu' => $this->getTrustee(),
        'title'=> $title,
        'breadcrumb'=> $this->breadcrumb,
      ];
      $resp['data'] =  $data;
      return $resp;
    }

    public function cpanel($url = null){
      return view('cpanel.index')->with($this->returnTemplate("Dashboard"));
    }

    public function pageUsers($url = null){
      return view('cpanel.pages.users.index')->with($this->returnTemplate("Daftar pengguna"));
    }

    public function pageUsersMember($url = null){
      return view('cpanel.pages.users_member.index')->with($this->returnTemplate("Daftar pengguna"));
    }

    public function pageSystemGroup($url = null){
      return view('cpanel.pages.system_group.index')->with($this->returnTemplate("Daftar group"));
    }

    public function pageSystemMember($url = null){
      return view('cpanel.pages.system_member.index')->with($this->returnTemplate("Daftar member"));
    }

    public function pageSystemMenu($url = null){
      return view('cpanel.pages.system_menu.index')->with($this->returnTemplate("System menu"));
    }

    public function pageSystemRole($url = null){
      return view('cpanel.pages.system_role.index')->with($this->returnTemplate("System role"));
    }

    public function loginPage($url = null){
      return view('cpanel.login')->with($this->returnTemplate("Login"));
    }

    public function pageTicket($url = null){
      return view('cpanel.pages.ticket.index')->with($this->returnTemplate("Ticket"));
    }

    
    public function pageDataTicket(){
      $query = M_ticket::select("*")
      ->Where("state", "=", "posted")
      ->orderBy('event_date')->get();
      $best_sell = M_ticket::select("*")
      ->take(2)
      ->Where("state", "=", "posted")
      ->orderBy('terjual','desc')->get();
      $response['data']=$query;
      $response['best']=$best_sell;
      return view('public.index')->with($response);
    }

    public function pageDataTicketDetail($id){
      $query = M_ticket::where("id", "=", $id)->get();
      $response['data']=$query;
      return view('public.detail_ticket')->with($response);
    }

  
}
