<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;

class ProjectController extends Controller
{
    private $validations = [
        'title'         => 'required|string|min:5|max:100',
        'type_id'       => 'required|integer|exists:types,id',
        'category_id'   => 'required|integer|exists:categories,id',
        'url_image'     => 'required|url|max:200',
        'content'       => 'required|string',
        'technologies'  => 'nullable|array',
        'technologies.*'=>'integer[exists:technologies, id'
    ];

    private $validation_messages = [
        'required'  => 'Il campo :attribute è obbligatorio',
        'min'       => 'Il campo :attribute deve avere almeno :min caratteri',
        'max'       => 'Il campo :attribute non può superare i :max caratteri',
        'url'       => 'Il campo deve essere un url valido',
        'exists'    => 'Valore non valido',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(5);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('categories', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validare i dati del form
        $request->validate($this->validations, $this->validation_messages);
      
        $data = $request->all();

        //salvare i dati nel db se validi
        $newProject = new Project();
        $newProject->title         = $data['title'];
        $newProject->type_id       = $data['type_id'];
        $newProject->category_id =   $data['category_id'];
        $newProject->url_image =     $data['url_image'];
        $newProject->content =       $data['content'];
        $newProject->save();

        //associare le tecnologie
        $newProject->technologies()->sync($data['technologies'] ?? []);

        //ridirezionare su una rotta di tipo get
        return to_route('admin.projects.show', ['project' => $newProject]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view ('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $categories = Category::all();
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'categories', 'types', 'technologies' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
         //validare i dati del form
         $request->validate($this->validations, $this->validation_messages);

         $data = $request->all();
// dd($data);  
         //aggiornare i dati nel db se validi
        
         $project->title       = $data['title'];
         $project->type_id     = $data['type_id'];
         $project->category_id = $data['category_id'];
         $project->url_image   = $data['url_image'];
         $project->content     = $data['content'];
         $project->update();
 
        //associare le tecnologie
         $project->technologies()->sync($data['technologies'] ?? []);

         //ridirezionare su una rotta di tipo get
         return to_route('admin.projects.show', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //disassociare tutte le tecnologie dal progetto
        $project->technologies()->sync([]);

        //elimino il progetto
        $project->delete();

        return to_route('admin.projects.index')->with('delete_success', $project);
    }
}
