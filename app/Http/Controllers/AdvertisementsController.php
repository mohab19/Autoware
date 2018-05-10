<?php

namespace App\Http\Controllers;

use App\models\Advertisement;
use App\models\Expenses;

use App\models\OutCome;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdvertisementsController extends Controller
{
    public $app_url;
    public $photo_directory;
    public function __construct()
    {
        $this->app_url = url()->to('/');
        $this->photo_directory = 'Announcements';
    }

    public function GetAdvertisements()
   {
       return Advertisement::get();
   }
    public function AddAdvertisementImage(Request $request , $file , $id)
    {
        if($request->picture) {
                $logo = $request->file('picture');
                $upload_to = app_path() . '/../public/images/' . $this->photo_directory . "/" . $id;
                $extension = $logo->getClientOriginalExtension();
                $file_name = $file . ".$extension";
                $success = $logo->move($upload_to, $file_name);
                if ($success)
                    return $this->app_url."/images/".$this->photo_directory."/".$id."/".$file_name;
                else
                    return 0;
        }
    }
    public function AddAdvertisementImages(Request $request , $file , $id)
    {
        if(is_array($request->attachments))
        {
            $pictures = array();
            $counter = 0;
            foreach ($request->file('attachments') as $item) {
                $counter++;
                $logo = $item;
                $upload_to = app_path() . '/../public/images/' . $this->photo_directory . "/" . $id;
                $extension = $logo->getClientOriginalExtension();
                $file_name = $file."-".$counter. ".$extension";
                $success = $logo->move($upload_to, $file_name);
                if($success)
                    $pictures[] = $this->app_url."/images/".$this->photo_directory."/".$id."/".$file_name;
                else
                    return 0;
            }
            $pictures_str  = implode("||", $pictures);
            return $pictures_str;
        }
    }
    public function Add(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'picture' => 'required|max:2040',
            'price' => 'required|numeric',
        ]);
        $data=$request->except('_token');
        $data['attachments']=0;
        $data['picture']=0;
        $advertisement = Advertisement::create($data);
        $id = $advertisement->id;
        $data['picture'] = $this->AddAdvertisementImage($request,"main",$id);
        if($request->attachments[0] != "" && $request->attachments[0] != " " && $request->attachments[0] != "0")
        {
            $data['attachments'] = $this->AddAdvertisementImages($request,"attachment",$id);
            $advertisement->attachments = $data['attachments'];
        }
        $advertisement->picture = $data['picture'];
        $advertisement->save();
        if($advertisement)
        {
            return 1;
        }
        else
            return 0;
    }
    public function Delete(Request $request)
    {
        $advertisement = Advertisement::find($request->id);
        if($advertisement)
        {
            if($advertisement->forcedelete())
                return 1;
            else
                return 0;
        }

    }
    public function Update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);
        $advertisement = Advertisement::find($request->id);
        if($advertisement)
        {
            $advertisement->title = $request->title;
            $advertisement->price = $request->price;
            $advertisement->description = $request->description;
            $advertisement->notes = $request->notes;
            $advertisement->save();
            return 1;
        }

    }
    public function UpdatePicture(Request $request)
    {
        $this->validate($request, [
            'picture' => 'required|max:2040',
        ]);
        $advertisement = Advertisement::find($request->id);
        if($advertisement)
        {
                $advertisement->picture  = $this->AddAdvertisementImage($request,"main",$request->id);
                $advertisement->save();
                return 1;
        }

    }
    public function UpdateAttachments(Request $request)
    {
        $this->validate($request, [
            'attachments' => 'required',
        ]);
        if($request->attachments[0])
        {
            $advertisement = Advertisement::find($request->id);
            if($advertisement)
            {
                $advertisement->attachments  = $this->AddAdvertisementImages($request,"attachment",$request->id);
                $advertisement->save();
                return 1;
            }
        }


    }
    public function Profile($id)
    {
        $advertisement = Advertisement::find($id);
            if($advertisement)
            {
                return view('pages.advertisement',
                    [
                        'advertisement' =>$advertisement,
                        'user' =>Auth::user()


                    ]);
            }
            else
                return view('errors.404');
    }

}
