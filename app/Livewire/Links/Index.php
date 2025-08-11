<?php

namespace App\Livewire\Links;

use App\Models\Link;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $uri = null;
    public ?string $search = null;
    public ?int $limit = 10;
    public ?string $sortBy = null;
    public ?string $sortDir = 'desc';
    public $status;

    protected $queryString = [
        'search'   => ['except' => '', 'as' => 'q'],
        'limit'   => ['except' => '10', 'as' => 'l'],
        'sortBy'  => ['except' => ''],
        'sortDir' => ['except' => 'desc'],
        'status'  => ['except' => ''],
        'uri'     => ['except' => ''],
    ];

    protected $listeners = [
        'link::updated' => '$refresh'
    ];

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.links.index', [
            'data' => Link::query()
                ->when($this->search,  fn(Builder $q) => $q->where('descricao', 'like', '%' . $this->search . '%'))
                ->when($this->uri,    fn(Builder $q) => $q->where('uri', 'like', '%' . $this->uri . '%'))
                ->when($this->status, fn(Builder $q) => $q->where('status', '=', $this->status))
                ->when($this->sortBy, fn(Builder $q) => $q->orderBy($this->sortBy, $this->sortDir))
                ->paginate($this->limit)
        ])->title('Links');
    }

    public function sort($column)
    {
        $this->sortDir = $this->sortBy == $column ? ($this->sortDir == 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortBy = $column;
    }
}
