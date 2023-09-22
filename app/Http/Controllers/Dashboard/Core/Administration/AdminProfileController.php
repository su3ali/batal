<?php

namespace App\Http\Controllers\Dashboard\Core\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Administration\AdminRequest;
use App\Http\Requests\Dashboard\Administration\ProfileRequest;
use App\Models\Admin;
use App\Models\User;
use App\Support\Crud\WithCrud;
use Collective\Html\FormFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    use WithCrud;
    protected string $path = 'dashboard.core.administration.profile';

    protected string $model = Admin::class;
    public function __construct() {
        $this->middleware('permission:admin_profile');
    }
    public function index(): View
    {
        $user = \auth()->guard('dashboard')->user();
        return view("{$this->path}.profile", compact('user'));
    }

    protected function updateAction(array $validated, Model $model)
    {
        $avatar = Arr::pull($validated, 'avatar');
        $avatar && uploadImage('avatar', $avatar, $model);
        $model->update($validated);
    }
    protected function validationAction(): array
    {
        return app(ProfileRequest::class)->validated();
    }
}
