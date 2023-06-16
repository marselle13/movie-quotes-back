<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>email</title>
    <style>
        .verify-button {
            background: #E31221;
            border-radius: 4px;
            border: none;
            padding: 7px 13px;
            color: #ffffff;
            cursor: pointer;
            width: 128px;
            text-align: center;
            text-decoration: none;
        }
    </style>

</head>
<html lang="en"
      style="font-family:sans-serif; background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%); color:white;display: grid;justify-content: center ; align-content: center">
<body>
<div style="max-width: 1220px; margin: 0 auto">
    <div style="text-align: center">
        <x-quotes-icon/>
        <h4>{{ __('messages.title') }}</h4>
    </div>
    <div style="display: flex; flex-direction: column; gap: 24px">
        <p>Hola {{ $user->name }}</p>
        <p>{{ $info }}</p>
        <a class="verify-button" href="{{$verificationUrl}}">{{ __('messages.verify_button') }}</a>
        <p>{{ __('messages.copy') }} </p>
        <p style="color:#DDCCAA;word-break: break-all">
            {{$verificationUrl}}
        </p>
        <p>{{ __('messages.problem') }}</p>
        <p>{{ __('messages.crew') }}</p>
    </div>
</div>
</body>
</html>
