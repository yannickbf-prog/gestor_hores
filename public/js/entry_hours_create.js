window.onload = function () {
    //let users_info = "{{ $users_info }}";
    var users_info = "{!! json_encode($users_info->toArray()) !!}";
    alert(users_info)
}