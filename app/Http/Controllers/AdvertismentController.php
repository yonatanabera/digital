<?php

namespace App\Http\Controllers;

use App\Models\Advertisment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class AdvertismentController extends Controller
{
    public function getAll()
    {
        return Advertisment::all();
    }

    public function getAllListings()
    {
        return Advertisment::where('ad_type', Advertisment::AD_TYPE_LISTING)->inRandomOrder()->get();
    }

    public function getAllHomepage()
    {
        return Advertisment::where('ad_type', Advertisment::AD_TYPE_HOMEPAGE)->inRandomOrder()->paginate(3);
    }

    public function save(Request $request)
    {
        $adv = new Advertisment();

        $request->validate([
            'company_name' => 'required',
            'ad_type' => 'required',
            'photo' => 'required',
            'priority' => 'required',
            'upload_date' => 'required',
            'down_date' => 'required'

        ]);

        $filename = "";

        if ($request->hasFile('photo')) {
            $filename = $request->file('photo')->store('images', 'public');
        } else {
            $filename = Null;
        }

        $adv->company_name = $request->company_name;
        $adv->ad_type = $request->ad_type;
        $request->priority && $adv->priority = $request->priority;
        $adv->photo = $filename;
        $request->caption && $adv->caption = $request->caption;
        $request->web_link && $adv->web_link = $request->web_link;
        $request->email_link && $adv->email_link = $request->email_link;
        $request->phone_link && $adv->phone_link = $request->phone_link;
        $adv->upload_date = $request->upload_date;
        $adv->down_date = $request->down_date;

        $result = $adv->save();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function update(Request $request, $id)
    {
        $adv = Advertisment::findOrFail($id);

        $destination = public_path("storage\\" . $adv->photo);

        $filename = "";
        if ($request->hasFile('photo')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $filename = $request->file('photo')->store('images', 'public');
        } else {
            $filename = $adv->photo;
        }


        $request->company_name && $adv->company_name = $request->company_name;
        $request->ad_type && $adv->ad_type = $request->ad_type;
        $request->priority && $adv->priority = $request->priority;
        $request->photo && $adv->photo = $filename;
        $request->caption && $adv->caption = $request->caption;
        $request->web_link && $adv->web_link = $request->web_link;
        $request->email_link && $adv->email_link = $request->email_link;
        $request->phone_link && $adv->phone_link = $request->phone_link;
        $request->upload_date && $adv->upload_date = $request->upload_date;
        $request->down_date && $adv->down_date = $request->down_date;


        $result = $adv->save();

        return $request->all();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function show($id)
    {
        return Advertisment::findOrFail($id);
    }

    public function destroy($id)
    {
        $adv = Advertisment::findOrFail($id);

        $destination = public_path("storage\\" . $adv->photo);

        // return $destination;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $adv->delete();

        return response()->json(['msg' => 'Doctor is deleted']);
    }
}
