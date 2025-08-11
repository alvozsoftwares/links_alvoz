<?php

namespace App\Livewire\Links;

use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Form extends Component
{
    public ?Link $dados = null;

    public ?String $descricao;
    public ?String $uri;
    public ?String $url; // link
    public $user_id;
    public $status;
    public $qrcode_link = null;

    public function mount($id = null) 
    {
        $this->dados = Link::find($id);

        $this->descricao = $this->dados->descricao ?? null;
        $this->uri = $this->dados->uri ?? null;
        $this->url = $this->dados->link ?? null;
        $this->user_id = $this->dados->user_id ?? Auth::user()->id;
        $this->status = $this->dados->status ?? 'active';

        $this->qrcode_link = ($this->dados == null) ? null : ENV('APP_URL') . '/ir/' . $this->uri;
    }

    protected function rules()
    {
        return [
            'descricao' => ['required', 'min:3', 'max:255'],
            'uri' => ['required', 'max:255'],
            'url' => ['required', 'max:255'],
            'status' => ['required'],
        ];
    }

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function save()
    {
        $validated = $this->validate();

        $dados = $this->dados ?? new Link();

        $dados->descricao = $validated['descricao'];
        $dados->uri = Str::slug($validated['uri']);
        $dados->link = $validated['url'];
        $dados->status = $validated['status'];
        $dados->user_id = $this->user_id;
        $dados->save();

        return redirect('/links/editar/'.$dados->id)
             ->with('success', 'Link salvo com sucesso!');
    }

    public function delete()
    {
        $this->link->delete();
        
        return redirect('/')
            ->with('success', 'Link excluído com sucesso.');
    }

    public function render()
    {
        $title = ($this->dados) ? 'Editar Link' : 'Adicionar Link' ;
        return view('livewire.links.form')
            ->title($title);
    }
}
