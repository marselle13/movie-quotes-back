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
            cursor: pointer;
            width: 128px;
            text-align: center;
            text-decoration: none;
        }
    </style>

</head>
<html lang="en"
      style="font-family:sans-serif">
<body
    style="width: 100%; height: 100%; background: #181623">
<div style="max-width: 1220px; margin:auto auto; padding-top:2.5rem; padding-bottom: 6rem ">
    <div style="text-align: center; color: white; margin-bottom: 4.5rem ">
        <img src="{{ asset('quote.png') }}" alt="quote">
        <h4 style="color:#DDCCAA">{{ __('messages.title') }}</h4>
    </div>
    <div>
        <p style="color:white;margin-bottom: 1.5rem">Hola {{ $user->name }}</p>
        <p style="color:white;margin-bottom: 2rem">{{__('messages.reset')}}</p>
        <a style="color:white;" class="verify-button" href="{{$verificationUrl}}">{{__('messages.reset_button')}}</a>
        <p style="color:white;margin-top: 2.5rem;margin-bottom: 1.5rem">{{ __('messages.copy') }}</p>
        <p style="color:#DDCCAA;word-break: break-all ;margin-bottom: 1.5rem">
            {{$verificationUrl}}
        </p>
        <p style="color:white ;margin-bottom: 1.5rem">{{ __('messages.problem') }}</p>
        <p style="color:white ;margin-bottom: 1.5rem">{{ __('messages.crew') }}</p>
    </div>
</div>
</body>
</html>
