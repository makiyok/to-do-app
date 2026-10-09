<?php

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('todo一覧')] class extends Component {
    /**
     * 開催日が近い順にイベントを取り出す。
     *
     * @return Collection<int, Todo>
     */
    #[Computed]
    public function todos(): Collection
    {
        return Todo::query()->with('user')->orderBy('due_at')->get();
    }
}; ?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">イベント一覧</flux:heading>
        @auth
            <flux:button :href="route('todos.create')" variant="primary" icon="plus" wire:navigate>イベントを登録</flux:button>
        @endauth
    </div>

    @if (session('status'))
        <flux:callout variant="success" icon="check-circle">
            <flux:callout.heading>{{ session('status') }}</flux:callout.heading>
        </flux:callout>
    @endif

    @if ($this->todos->isEmpty())
        <flux:text>イベントはまだありません。</flux:text>
    @else
        <flux:table>
            <flux:table.columns>
                <flux:table.column>イベント</flux:table.column>
                <flux:table.column>開催日時</flux:table.column>
                <flux:table.column>カテゴリ</flux:table.column>
                <flux:table.column>主催</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->todos as $todo)
                    <flux:table.row wire:key="todo-{{ $todo->id }}">
                        <flux:table.cell variant="strong">{{ $todo->title }}</flux:table.cell>
                        <flux:table.cell>{{ $todo->start_at->isoFormat('M月D日(ddd) HH:mm') }} 〜 {{ $todo->due_at->isoFormat('HH:mm') }}</flux:table.cell>
                        <flux:table.cell>{{ $todo->category }}</flux:table.cell>
                        <flux:table.cell>{{ $todo->user->name }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($todo->isOwnedBy(auth()->user()))
                                <flux:button :href="route('todos.edit', $todo)" size="sm" icon="pencil-square" wire:navigate>編集</flux:button>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endif
</div>
