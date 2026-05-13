@extends('layouts.admin')

@section('content')
<div class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title">
                        <i class="fas fa-bars"></i> About Menu Items
                    </h1>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="{{ route('admin.about-menus.create') }}" class="button is-success">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Add New Menu Item</span>
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="notification is-success">
                <button class="delete"></button>
                {{ session('success') }}
            </div>
        @endif

        <div class="box">
            <table class="table is-fullwidth is-striped is-hoverable">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Route</th>
                        <th>Icon</th>
                        <th>Content</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $menu->order }}</td>
                            <td><strong>{{ $menu->title }}</strong></td>
                            <td><code>{{ $menu->route }}</code></td>
                            <td>
                                @if($menu->icon)
                                    <i class="{{ $menu->icon }}"></i> {{ $menu->icon }}
                                @else
                                    <span class="tag is-light">None</span>
                                @endif
                            </td>
                            <td>
                                @if($menu->content)
                                    <small>{{ Str::limit($menu->content, 60) }}</small>
                                @else
                                    <span class="tag is-light">No content</span>
                                @endif
                            </td>
                            <td>
                                @if($menu->is_active)
                                    <span class="tag is-success">Active</span>
                                @else
                                    <span class="tag is-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.about-menus.edit', $menu->id) }}" class="button is-small is-info">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('admin.about-menus.destroy', $menu->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button is-small is-danger" onclick="return confirm('Are you sure?')">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="has-text-centered">
                                <em>No menu items found</em>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
        const $notification = $delete.parentNode;
        $delete.addEventListener('click', () => {
            $notification.parentNode.removeChild($notification);
        });
    });
});
</script>
@endsection
