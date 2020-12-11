<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;

use App\Atikublog as Blog;
use App\Atikuphoto as Gallery;
use App\Atikucomment as Comment;


class AtikuController extends Controller{

	public function addnew($party){
		return view('atiku.addblog')
			->with('editor', true)
			->with('party', (strtolower($party) != 'apc') ? 'pdp':'apc')
			->with('pg_title', 'New Blog Post');
	}

	public function allBlogs(){
		return view('atiku.blogs')
			->with('blogs', Blog::with('comments')->get())
			->with('pg_title', 'Manage Blogs');
	}

	public function blogSingle($id){
		$b = Blog::with('comments')->find($id);
		return view('atiku.single')
				->with('pg_title', 'View Blog Post')
				->with('blog', $b);
	}

	public function delBlog($id){
		$b = Blog::find($id);
		$imgfile = public_path(). DS . 'atiku' . DS . 'uploads' . DS . $b->image;
		@chmod($imgfile, 0777);
		@unlink($imgfile);
		$b->delete();
		return redirect()->back();
	}

	public function approveComment($id){
		$c = Comment::find($id);
		$c->verified = ($c->verified) ? false : true;
		$c->save();
		return redirect()->back();
	}

	public function process(Request $request){
		pr($request->all());

		//upload the image first... 
		$this->validate($request, [
	        'blogimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
	    ]);

	    if ($request->hasFile('blogimg')) {
	        $image = $request->file('blogimg');
	        $fname = 'img_'.time().'.'.$image->getClientOriginalExtension();
	        $destinationPath = public_path() . DS . 'atiku'. DS. 'uploads';
	        if($image->move($destinationPath, $fname)){

	        	// create instance
	        	$wimg = ($request['blogparty'] != 'apc') ? 'watermark.png' : 'apcmark.png';

	        	$watermark = public_path().DS.'atiku'.DS. $wimg;

				$img = Image::make($destinationPath . DS . $fname);

				// create a new empty image resource with black background
				$canvas = Image::canvas(800, 600, '#000000');

	        	//apply intervention image...
	        	$img->resize(800, 600, function ($constraint) {
				    $constraint->aspectRatio();
				});

				// insert watermark at bottom-right corner with 10px offset
				$img->insert($watermark, 'bottom-right', 40, 40);
				$canvas->insert($img, 'center');
				$canvas->save($destinationPath . DS . $fname); //save to the destinationpath filename...

	        }

	        $b = new Blog;
	        $b->title = $request['blogtitle'];
	        $b->content = $request['blogcontent'];
	        $b->excerpt = $request['blogexerpt'];
	        $b->party = $request['blogparty'];
	        $b->image = $fname;
	        
	        if($b->save()){
				return redirect()->back()->with('success','true');
	        }else{
				return redirect()->back()->with('failed','true');
	        }

	        
	    }
	}


    //.image uploader functions..................


	public function addImages(){
		return view('atiku.upload')
			->with('plupload', true)
			->with('pg_title', 'Manage Photos');
	}

	public function allPhotos(){
		return view('atiku.gallery')
			->with('photos', Gallery::all())
			->with('pg_title', 'Manage Photos');
	}

	public function delPhoto($id){
		$g = Gallery::find($id);
		$imgfile = public_path(). DS . 'atiku' . DS . 'gallery' . DS . $g->imgfile;
		@chmod($imgfile, 0777);
		@unlink($imgfile);
		$g->delete();
		return redirect()->back();
	}

	public function uploadImages(Request $request){


       // pr($request, true);

		//ob_flush();		ob_flush();

		$image = $request->file('file');
	      
        $fname = 'img_'.time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path() . DS . 'atiku'. DS . 'gallery';

        if($image->move($destinationPath, $fname)){


        		// create instance
        	$watermark = public_path().DS.'atiku'.DS.'watermark.png';

			$img = Image::make($destinationPath . DS . $fname);

			// create a new empty image resource with black background
			$canvas = Image::canvas(800, 600, '#000000');

        	//apply intervention image...
        	$img->resize(800, 600, function ($constraint) {
			    $constraint->aspectRatio();
			});

			// insert watermark at bottom-right corner with 10px offset
			$img->insert($watermark, 'bottom-right', 40, 40);
			$canvas->insert($img, 'center');
			
			$canvas->save($destinationPath . DS . $fname);
        
        	//pr($request, true);

			$b = new Gallery;
	        $b->imgfile = $fname;
	        $b->title = $request->input('title');
	        $b->description = $request->input('desc');
	        $b->save();

	        
        }

        /* 
		*/

	}


}
