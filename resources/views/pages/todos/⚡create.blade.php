<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Title('todoを登録')] class extends Component {
    #[Validate('required|string|max:100')]
    public string $title = '';

    #[Validate('required|string|max:2000')]
    public string $memo = '';

    #[Validate('required|string|max:100')]
    public string $category = '';

    #[Validate('required|date')]
    public string $start_at = '';

    #[Validate('required|date|after:start_at')]
    public string $due_at = '';

    public bool $submitted = false;

    public function save(): void
    {
        $this->validate();

        // まだデータベースには保存しない。入力が通ったことを画面に出すだけ
        $this->submitted = true;
    }
}; ?>

<div class="mx-auto max-w-2xl space-y-6">
    <flux:heading size="xl">イベントを登録</flux:heading>

    @if ($submitted)
        <flux:callout variant="success" icon="check-circle">
            <flux:callout.heading>入力内容を受け付けました</flux:callout.heading>
            <flux:callout.text>{{ $title }}（{{ $category }}）{{ $start_at }} 〜 {{ $due_at }}</flux:callout.text>
        </flux:callout>
    @endif

    <form wire:submit="save" class="space-y-6">
        <flux:input wire:model="title" label="タイトル" placeholder="例: 岩手山 朝焼けトレッキング" />
        <flux:textarea wire:model="memo" label="説明" rows="6" />
        <flux:input wire:model="category" label="会場" placeholder="例: 岩手山 馬返し登山口" />

        <div class="grid gap-6 sm:grid-cols-2">
            <flux:input wire:model="start_at" label="開始日時" type="datetime-local" />
            <flux:input wire:model="due_at" label="終了日時" type="datetime-local" />
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">登録する</flux:button>
        </div>
    </form>
</div>
