<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Das :Attribut muss akzeptiert werden.',
    'accepted_if' => 'Das :Attribut muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => 'Das :Attribut ist keine gültige URL.',
    'after' => 'Das :Attribut muss ein Datum nach :date sein.',
    'after_or_equal' => 'Das :Attribut muss ein Datum nach oder gleich :Datum sein.',
    'alpha' => 'Das :Attribut darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :Attribut darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :Attribut muss nur aus Buchstaben und Zahlen bestehen.',
    'array' => 'Das :Attribut muss ein Array sein.',
    'before' => 'Das :Attribut muss ein Datum vor :date sein.',
    'before_or_equal' => 'Das :Attribut muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'numeric' => 'Das :Attribut muss zwischen :min und :max liegen.',
        'file' => 'Das :Attribut muss zwischen :min und :max Kilobyte liegen.',
        'string' => 'Das :Attribut muss zwischen :min und :max Zeichen lang sein.',
        'array' => 'Das :Attribut muss zwischen :min und :max Elemente haben.',
    ],
    'boolean' => 'Das Feld :attribute muss wahr oder falsch sein.',
    'confirmed' => 'Die :attribute-Bestätigung stimmt nicht überein.',
    'current_password' => 'Das Passwort ist inkorrekt.',
    'date' => 'Das :Attribut ist kein gültiges Datum.',
    'date_equals' => 'Das :Attribut muss ein Datum gleich :date sein.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'Das :Attribut und :andere müssen unterschiedlich sein.',
    'digits' => 'Das :Attribut muss :digits digits sein.',
    'digits_between' => 'Das :Attribut muss zwischen :min und :max Ziffern liegen.',
    'dimensions' => 'Das :Attribut hat ungültige Bildabmessungen.',
    'distinct' => 'Das Feld :attribute hat einen doppelten Wert.',
    'email' => 'Das :Attribut muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :Attribut muss mit einem der folgenden enden: :Werte.',
    'exists' => 'Das ausgewählte :Attribut ist ungültig.',
    'file' => 'Das :Attribut muss eine Datei sein.',
    'filled' => 'Das Feld :attribute muss einen Wert haben.',
    'gt' => [
        'numeric' => 'Das :Attribut muss größer als :Wert sein.',
        'file' => 'Das :Attribut muss größer als :Wert Kilobyte sein.',
        'string' => 'Das :Attribut muss größer als :Wertzeichen sein.',
        'array' => 'Das :Attribut muss mehr als :Wert-Elemente enthalten.',
    ],
    'gte' => [
        'numeric' => 'Das :Attribut muss größer oder gleich :Wert sein.',
        'file' => 'Das :Attribut muss größer oder gleich :Wert Kilobyte sein.',
        'string' => 'Das :Attribut muss größer oder gleich :Wert Zeichen sein.',
        'array' => 'Das :Attribut muss mindestens :value Elemente enthalten.',
    ],
    'image' =>'Das :Attribut muss ein Bild sein.',
    'in' => 'Das ausgewählte :Attribut ist ungültig.',
    'in_array' => 'Das Feld :attribute existiert nicht in :other.',
    'integer' => 'Das :Attribut muss eine ganze Zahl sein.',
    'ip' => 'Das :Attribut muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :Attribut muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :Attribut muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute muss ein gültiger JSON-String sein.',
    'lt' => [
        'numeric' => 'Das :Attribut muss kleiner als :Wert sein.',
        'file' => 'Das :Attribut muss kleiner als :value Kilobyte sein.',
        'string' => 'Das :Attribut muss weniger als :value Zeichen enthalten.',
        'array' => 'Das :Attribut muss weniger als :value Elemente enthalten.',
    ],
    'lte' => [
        'numeric' => 'Das :Attribut muss kleiner oder gleich :Wert sein.',
        'file' => 'Das :Attribut muss kleiner oder gleich :value Kilobyte sein.',
        'string' => 'Das :Attribut muss kleiner oder gleich :Wertzeichen sein.',
        'array' => 'Das :Attribut darf nicht mehr als :value Elemente enthalten.',
    ],
    'max' => [
        'numeric' => 'Das :Attribut darf nicht größer als :max sein.',
        'file' => 'Das :Attribut darf nicht größer als :max Kilobyte sein.',
        'string' => 'Das :Attribut darf nicht größer als :max Zeichen sein.',
        'array' => 'Das :Attribut darf nicht mehr als :max Elemente enthalten.',
    ],
    'mimes' => 'Das :Attribut muss eine Datei des Typs: :values sein.',
    'mimetypes' => 'Das :Attribut muss eine Datei des Typs: :values sein.',
    'min' => [
        'numeric' => 'Das :Attribut muss mindestens :min sein.',
        'file' => 'Das :Attribut muss mindestens :min Kilobyte groß sein.',
        'string' => 'Das :Attribut muss mindestens :min Zeichen lang sein.',
        'array' => 'Das :Attribut muss mindestens :min Elemente enthalten.',
    ],
    'multiple_of' => 'Das :Attribut muss ein Vielfaches von :Wert sein.',
    'not_in' => 'Das ausgewählte :Attribut ist ungültig.',
    'not_regex' => 'Das :Attributformat ist ungültig.',
    'numeric' => 'Das :Attribut muss eine Zahl sein.',
    'password' => 'Das Passwort ist inkorrekt.',
    'present' => 'Das Feld :attribute muss vorhanden sein.',
    'regex' => 'Das :attribute-Format ist ungültig.',
    'required' => 'Das Feld :attribute ist erforderlich.',
    'required_if' => 'Das Feld :attribute ist erforderlich, wenn :other :value ist.',
    'required_unless' => 'Das Feld :attribute ist erforderlich, es sei denn, :other ist in :values enthalten.',
    'required_with' => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Das Feld :attribute ist erforderlich, wenn :Werte vorhanden sind.',
    'required_without' => 'Das Feld :attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das Feld :attribute ist erforderlich, wenn keiner der :Werte vorhanden ist.',
    'prohibited' => 'Das :Attributfeld ist verboten',
    'prohibited_if' => 'Das Feld :attribute ist verboten, wenn :other :value ist.',
    'prohibited_unless' => 'Das Feld :attribute ist verboten, es sei denn, :other ist in :values enthalten.',
    'prohibits' => 'Das :attribute-Feld verhindert, dass :other vorhanden ist.',
    'same' => 'Das :Attribut und :andere müssen übereinstimmen.',
    'size' => [
        'numeric' => 'Das :Attribut muss :size sein.',
        'file' => 'Das :Attribut muss :size Kilobyte sein.',
        'string' => 'Das :Attribut muss :size Zeichen sein.',
        'array' => 'Das :Attribut muss :size-Elemente enthalten.',
    ],
    'starts_with' => 'Das :Attribut muss mit einem der folgenden beginnen: :Werte.',
    'string' => 'Das :Attribut muss ein String sein.',
    'timezone' => 'Das :Attribut muss eine gültige Zeitzone sein.',
    'unique' => 'Das :Attribut wurde bereits vergeben.',
    'uploaded' => 'Das :Attribut konnte nicht hochgeladen werden.',
    'url' => 'Das :Attribut muss eine gültige URL sein.',
    'uuid' => 'Das :Attribut muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
