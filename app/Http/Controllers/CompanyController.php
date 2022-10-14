<?php
/**
* Class and Function List:
* Function list:
* - getCurrentCompanyId()
* - index()
* - create()
* - store()
* - edit()
* - update()
* - destroy()
* Classes list:
* - CompanyController extends Controller
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    //
    public function getCurrentCompanyId()
    {
        try
        {
            // $id = DB::table('company')->value('id')->first();
            //  dd($id);
            //$company = Company::first();
            $company = Company::where('unique_id', session('creator_id'))->first();
            // dd($company);
            if ($company !== null)
            {
                return $company;
            }
            else
            {
                return false;
            }
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    public function index()
    {
        // dd('hey');
        $company = DB::table('company')->get();
        return view('company.companyview', ['company_data' => $company]);
    }

    public function create()
    {
        return view('company.companycreate');
    }
    public function store(Request $r)
    {
        $company               = new Company;
        $company->name         = $r->input('Name');
        $Name                  = $r->input('Name');
        $company->location     = $r->input('Location');
        $company->address       = $r->input('Adress');
        $company->phone_number = $r->input('Phonenumber');
        // dd($r->file('Logo'));
        if ($r->hasFile('Logo'))
        {
            $file                  = $r->file('Logo');
            $extension             = $file->getClientOriginalExtension();
            // dd($extension);
            $filename              = 'image_' . time() . '.' . $extension;
            $filepath              = 'uploads/' . $filename;
            // $filepath = public_path('\\uploads\\' . $filename);
            // dd($filepath);
            // $file->move('uploads/',$filename);
            //  Storage::move($file,$filepath);
            $file->move('uploads/', $filename);
            $company->logo      = $filepath;
        }
        $compid             = Company::orderBy('id', 'DESC')->first();

        if ($compid == null)
        {
            $incrementNum       = '1';
        }
        else
        {
            if ($compid->unique_id == "")
            {
                $incrementNum       = '1';
            }
            else
            {
                $incrementNum       = (int)explode('_', $compid->unique_id) [1] + 1;
            }
        }

        $unique_id          = strtolower(mb_substr(str_replace(' ', '', $Name) , 0, 5)) . '_' . (string)$incrementNum;
        $prefix             = strtolower(mb_substr(str_replace(' ', '', $Name) , 0, 5));

        $company->unique_id = $unique_id;
        $company->prefix    = $prefix;
        $company->save();

        return redirect(url('/company'));
    }

    public function edit($id)
    {
        $company_data = DB::table('company')->where('id', $id)->get();

        return view('company.companyedit', ['company'                       => $company_data]);
    }
    public function update(Request $r, $id)
    {

        $company               = Company::find($id);

        $company->name         = $r->input('Name');
        $Name                  = $r->input('Name');
        $company->location     = $r->input('Location');
        $company->adress       = $r->input('Adress');
        $company->phone_number = $r->input('Phonenumber');
        if ($r->hasFile('Logo'))
        {

            $path                  = $company->logo;
            // dd($path);
            if (File::exists($path))
            {
                File::delete($path);
            }
            $file      = $r->file('Logo');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $extension;
            $filepath  = 'uploads/' . $filename;
            $file->move('uploads/', $filename);
            $company->logo = $filepath;
        }

        $company->save();

        return redirect(url('/company'));

    }
    public function destroy($id)
    {
        DB::table('company')->where('id', $id)->delete();

        return redirect(url('/company'));

    }

}

