<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Kullanıcının açtığı ve ekip üyesi olduğu projeleri listele
    public function index()
    {
        $user = Auth::user();
        $managedProjects = $user->managedProjects()->get();
        $memberProjects = $user->memberProjects()->where('manager_id', '!=', $user->id)->get();
        return view('projects.index', compact('managedProjects', 'memberProjects'));
    }

    // Proje oluşturma formu
    public function create()
    {
        // Ekip üyeleri için kullanıcı listesini al
        $users = User::where('id', '!=', Auth::id())->get();
        return view('projects.create', compact('users'));
    }

    // Proje kaydet
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'done_jobs' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $project = new Project();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->price = $request->price;
        $project->done_jobs = $request->done_jobs;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->manager_id = Auth::id();
        $project->save();

        // Ekip üyelerini ekle
        if ($request->members) {
            $project->members()->sync($request->members);
        }

        return redirect()->route('projects.index')->with('success', 'Proje oluşturuldu!');
    }

    // Proje detayları
    public function show(Project $project)
    {
        $this->authorizeView($project);
        return view('projects.show', compact('project'));
    }

    // Proje düzenleme formu
    public function edit(Project $project)
    {
        $this->authorizeEdit($project);
        $users = User::where('id', '!=', Auth::id())->get();
        return view('projects.edit', compact('project', 'users'));
    }

    // Proje güncelle
    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        // Yalnızca ekip üyesi ise sadece done_jobs güncelleyebilir
        if ($project->members->contains($user) && $project->manager_id !== $user->id) {
            $request->validate([
                'done_jobs' => 'nullable|string',
            ]);
            $project->done_jobs = $request->done_jobs;
            $project->save();
            return redirect()->route('projects.index')->with('success', 'Yapılan işler güncellendi!');
        }
        // Yönetici ise tüm alanları güncelleyebilir
        $this->authorizeEdit($project);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'done_jobs' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);
        $project->name = $request->name;
        $project->description = $request->description;
        $project->price = $request->price;
        $project->done_jobs = $request->done_jobs;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->save();
        if ($request->members) {
            $project->members()->sync($request->members);
        } else {
            $project->members()->detach();
        }
        return redirect()->route('projects.index')->with('success', 'Proje güncellendi!');
    }

    // Proje sil
    public function destroy(Project $project)
    {
        $this->authorizeEdit($project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proje silindi!');
    }

    // Yalnızca yönetici veya ekip üyesi görebilir
    private function authorizeView(Project $project)
    {
        $user = Auth::user();
        if ($project->manager_id !== $user->id && !$project->members->contains($user)) {
            abort(403, 'Bu projeyi görüntüleme yetkiniz yok.');
        }
    }

    // Yalnızca yönetici düzenleyebilir
    private function authorizeEdit(Project $project)
    {
        $user = Auth::user();
        if ($project->manager_id !== $user->id) {
            abort(403, __('projects.no_edit_permission'));
        }
    }
}
