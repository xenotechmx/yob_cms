<tr>
    <td class="select-row" data-id="{!! $children['id'] !!}">{!! $children['name'] !!}</td>
    <td class="text-center">
        <input type="checkbox" class="view aaaaa" <?php echo (($user_profile->checkPermitionByModule($children['id'], "view") == 1) ? "checked" : ""); ?> />
        <input type="hidden" name="child[{!! $children['id'] !!}][view]" value="<?php echo $user_profile->checkPermitionByModule($children['id'], "view"); ?>" />
    </td>
    <td class="text-center">
        <input type="checkbox" class="view" <?php echo (($user_profile->checkPermitionByModule($children['id'], "create") == 1) ? "checked" : ""); ?> />
        <input type="hidden" name="child[{!! $children['id'] !!}][create]" value="<?php echo $user_profile->checkPermitionByModule($children['id'], "create"); ?>" />
    </td>
    <td class="text-center">
        <input type="checkbox" class="view" <?php echo (($user_profile->checkPermitionByModule($children['id'], "delete") == 1) ? "checked" : ""); ?> />
        <input type="hidden" name="child[{!! $children['id'] !!}][delete]" value="<?php echo $user_profile->checkPermitionByModule($children['id'], "delete"); ?>" />
    </td>
    <td class="text-center">
        <input type="checkbox" class="view" <?php echo (($user_profile->checkPermitionByModule($children['id'], "update") == 1) ? "checked" : ""); ?> />
        <input type="hidden" name="child[{!! $children['id'] !!}][update]" value="<?php echo $user_profile->checkPermitionByModule($children['id'], "update"); ?>" />
    </td>
</tr>



@if (count($children['child']) > 0)
    @foreach ($children['child'] as $children)
        @include('sistema.perfil.partials.innerTable', ['children' => $children, 'parentID' => $parentID])
    @endforeach
@endif
