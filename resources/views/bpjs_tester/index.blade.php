<form action="/kepriregistrasi/bpjs-tester" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <textarea name="response" id="response" class="form-input" style="width: 100%; height: 300px;"></textarea>
    <br>
    <input type="text" name="key" id="key">
    <br>
    <input type="submit" value="Submit">
</form>