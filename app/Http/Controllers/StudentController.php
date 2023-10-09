<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Stringable;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\HttpKernel\Event\ResponseEvent;


class StudentController extends Controller
{
    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            
            $query = Student::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);
            return $query;
            // return new CountryCollection($query);
        } else {

             $students = Student::all();
        return response()->json($students);
            // If 0
            // $query = $this->country->get();

            // return new CountryCollection($query);
        }


        // $students = Student::all();
        // return response()->json($students);
    }

    public function indexid($id)
    {
        $students = Student::find($id);

        return response()->json($students);
    }

       public function store(Request $request)
        {
            // dd($request->image);
            // $request->validate([
            //     'name' => 'Required|max:50',
            //     'class' => 'Required|max:50',
            //     'image' => 'Required',
            // ]);
    
            // dd('dsfsdfgdsf');
    
            

            // $data = $request->all();
            // dd($data->['image']);
    
            // // Handle the base64-encoded image and store it in a unique file
            // if ($data['image']) {
            //     $file = $data['image'];
            //     $directory = 'imagesss';
            //     $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            //     $path = $directory . '/' . $filename;
            //     if (!File::exists($directory)) {
            //         File::makeDirectory($directory, 0775, true, true);
            //     }
    
            //     $image_parts = explode(";base64,", $file);
            //     $image_base64 = base64_decode($image_parts[1]);
            //     file_put_contents($path, $image_base64);
            //     $data['image'] = 'http://localhost:8000/' . $path;
    
            // }
            // $item = Student::create($data);

            // if($item){
            //     return response()->json([
            //         'status'=>'200',
            //         'message'=>'student added successfully'
            //     ]);
            // }else{
            //     return response()->json([
            //         'status'=>'201',
            //         'message'=>'not found student'
            //     ]);
            // }
    
            $store = new Student;
            $store->name = $request->input('name');
            $store->class = $request->input('class');
            if ($request->image) {
                $file = $request->image;
                // dd($file);
                $directory = 'imagesss';
                $filename = Str::random(10).'_'.uniqid().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                $path = $directory.'/'.$filename;
    
                // dd($filename, $path);
    
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0775, true, true);
                }
    
                $image_parts = explode(";base64,", $file);
                // dd($image_parts);
                $image_base64 = base64_decode($image_parts[1]);
                // dd($image_base64);
                file_put_contents($path, $image_base64);
                $store->image = 'http://localhost:8000/'.$path;
            }
            $store->save();
    
            if (($store->save())) {
    
                return response()->json([
                    'status' => 200,
                    'message' => 'added successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'not found path'
                ]);
            }
        }
    
    public function edit($id)
    {
        $edit = Student::find($id);
        if ($edit) {

            return response()->json([
                'status' => 202,
                'message' => 'update successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'not found student'
            ]);
        }
    }
    public function update(Request $request, $id)
    {

        // dd($request->all(),$id);
        $update = Student::find($id);

        if ($update) {
            $update->name = $request->input('name');
            $update->class = $request->input('class');
            // if($request->hasFile('image'))
            // {
            //  $destination = 'imagesss/'.$update->image;

            //  if(File::exists($destination))
            //  {
            //     File::delete($destination);
            //  }
            //    $file = $request->file('image');
            // $extention = $file->getClientOriginalExtension();
            // $fileName = 'http://localhost:8000/imagesss/'.time().'.'.$extention;
            // $file->move('imagesss', $fileName);
            // $update->image=$fileName;
            // }

            if ($request->image) {
                $file = $request->image;
                // dd($file);
                $directory = 'imagesss';
                $filename = Str::random(10).'_'.uniqid().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                $path = $directory.'/'.$filename;
    
                // dd($filename, $path);
    
                if (!File::exists($directory)) {
                    File::delete($directory, 0775, true, true);
                }
    
                $image_parts = explode(";base64,", $file);
                // dd($image_parts);
                $image_base64 = base64_decode($image_parts[1]);
                // dd($image_base64);
                file_put_contents($path, $image_base64);
                $update->image = 'http://localhost:8000/'.$path;
    
                // $img = Image::make($image);
                // $img->resize($width, $height, function ($constraint) {
                // })->save($path);
    
                // return $path;
            }
            
            $update->update();
            return response()->json([
                'status' => 200,
                'message' => 'update successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'not found student'
            ]);
        }
    }

    public function delete($id){
     $student = Student::find($id);
       $delete = $student->delete();
     if( $delete){
        return response()->json([
            'status' => 200,
            'message' => 'deleted successfully'
        ]);
     }else{
        return response()->json([
            'status' => 404,
            'message' => 'not found student'
        ]);
     }
    }
}
