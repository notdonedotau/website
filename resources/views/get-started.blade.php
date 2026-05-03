@php
    $plans = [
        'starter' => [
            'name' => 'Starter',
            'price' => '$9/mo',
            'pricing_id' => '4',
            'description' => '10 components, 1 admin user, and 250 subscribers.',
        ],
        'growth' => [
            'name' => 'Growth',
            'price' => '$29/mo',
            'pricing_id' => '6',
            'description' => '100 components, 3 admin users, custom domain, and 1000 subscribers.',
        ],
        'business' => [
            'name' => 'Business',
            'price' => '$79/mo',
            'pricing_id' => '8',
            'description' => '250 components, 10 admin users, advanced customisation, and 2000 subscribers.',
        ],
    ];

    $countries = [
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua and Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BQ' => 'Bonaire, Sint Eustatius and Saba',
        'BA' => 'Bosnia and Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'CV' => 'Cabo Verde',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic of the',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote d’Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CW' => 'Curacao',
        'CY' => 'Cyprus',
        'CZ' => 'Czechia',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'SZ' => 'Eswatini',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island and McDonald Islands',
        'VA' => 'Holy See',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KP' => 'Korea, Democratic People’s Republic of',
        'KR' => 'Korea, Republic of',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Laos',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MK' => 'North Macedonia',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestine',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
        'KN' => 'Saint Kitts and Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre and Miquelon',
        'VC' => 'Saint Vincent and the Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome and Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SX' => 'Sint Maarten',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia and the South Sandwich Islands',
        'SS' => 'South Sudan',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard and Jan Mayen',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad and Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks and Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Minor Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.S.',
        'WF' => 'Wallis and Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];

    $selectedPlan = str($errors->any() ? old('plan', 'growth') : request()->string('plan')->lower()->value())->lower()->value();
    $selectedPlan = array_key_exists($selectedPlan, $plans) ? $selectedPlan : 'growth';
    $turnstileSiteKey = app(\App\Services\Turnstile::class)->enabled() ? config('services.turnstile.site_key') : null;
@endphp

@extends('layouts.site', [
    'title' => 'Get Started | notdone.au',
    'description' => 'Start a 1-month free trial of Not Done. No credit card required.',
])

@if (filled($turnstileSiteKey))
    @push('head')
        @once
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        @endonce
    @endpush
@endif

@section('content')
    <section class="content-page get-started-page">
        <div class="get-started-hero">
            <p class="eyebrow">No credit card required</p>
            <h1>Start your status page.</h1>
            <p class="page-intro">
                Enter your details to create your status page.
            </p>
        </div>

        @if (session('get_started_status'))
            <div class="form-alert form-alert--success">
                {{ session('get_started_status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="form-alert form-alert--error" role="alert">
                <strong>{{ $errors->first() }}</strong>
                @if ($errors->count() > 1)
                    <p>Please review the remaining items below.</p>
                    <ul class="form-alert__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <form
            class="get-started-form"
            method="POST"
            action="{{ route('get-started.store') }}"
            data-get-started-form
        >
            @csrf

            <input type="hidden" name="group_id" value="2">
            <input type="hidden" name="pricing_id" value="{{ $plans[$selectedPlan]['pricing_id'] }}" data-pricing-id-input>
            <input type="hidden" name="status_page_slug" value="{{ old('status_page_slug') }}" data-status-page-slug-input>

            <div class="get-started-form__main">
                <section class="get-started-panel" aria-labelledby="details-heading">
                    <div class="section-heading">
                        <p class="eyebrow">Your details</p>
                        <h2 id="details-heading">Account contact</h2>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="first_name">First Name</label>
                            <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" autocomplete="given-name" required>
                            @error('first_name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="last_name">Last Name</label>
                            <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" autocomplete="family-name" required>
                            @error('last_name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="mobile">Mobile</label>
                            <input id="mobile" name="mobile" type="tel" value="{{ old('mobile') }}" autocomplete="tel" required>
                            @error('mobile')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required>
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                            @error('password_confirmation')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="country">Country</label>
                            <select
                                id="country"
                                name="country"
                                autocomplete="country"
                                data-country-select
                                data-country-autodetect="{{ old('country') ? 'false' : 'true' }}"
                                required
                            >
                                @foreach ($countries as $countryCode => $countryName)
                                    <option value="{{ $countryCode }}" @selected(old('country', 'AU') === $countryCode)>{{ $countryName }}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="postcode">Postcode</label>
                            <input id="postcode" name="postcode" type="text" value="{{ old('postcode') }}" autocomplete="postal-code" required>
                            @error('postcode')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="get-started-panel" aria-labelledby="status-page-heading">
                    <div class="section-heading">
                        <p class="eyebrow">Status page</p>
                        <h2 id="status-page-heading">Name your page</h2>
                    </div>

                    <div class="form-field">
                        <label for="status_page_name">Status Page Name</label>
                        <input
                            id="status_page_name"
                            name="status_page_name"
                            type="text"
                            value="{{ old('status_page_name') }}"
                            autocomplete="organization"
                            data-status-page-name-input
                            required
                        >
                        @error('status_page_name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        @error('status_page_slug')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="slug-preview" aria-live="polite">
                        <span>Your generated page</span>
                        <output data-status-page-slug-output>your-status-page.notdone.cloud</output>
                    </div>
                </section>
            </div>

            <aside class="get-started-panel get-started-plan" aria-labelledby="plan-heading">
                <div class="section-heading">
                    <p class="eyebrow">Plan</p>
                    <h2 id="plan-heading">Choose your trial plan</h2>
                </div>

                <div class="plan-options" role="radiogroup" aria-label="Choose a plan">
                    @foreach ($plans as $planKey => $plan)
                        <label class="plan-option @if ($planKey === $selectedPlan) is-selected @endif">
                            <input
                                type="radio"
                                name="plan"
                                value="{{ $planKey }}"
                                data-plan-option
                                data-pricing-id="{{ $plan['pricing_id'] }}"
                                @checked($planKey === $selectedPlan)
                            >
                            <span class="plan-option__content">
                                <span class="plan-option__header">
                                    <span>{{ $plan['name'] }}</span>
                                    <strong>{{ $plan['price'] }}</strong>
                                </span>
                                <span>{{ $plan['description'] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('plan')
                    <p class="form-error">{{ $message }}</p>
                @enderror

                <p class="get-started-plan__note trial-note">
                    <svg class="trial-note__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M3.5 7.5A2.5 2.5 0 0 1 6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9Z" />
                        <path d="M3.5 9h17M7 15h3" />
                    </svg>
                    <span>No credit card required. 1-month free trial.</span>
                </p>

                <label class="agreement-field">
                    <input name="terms_accepted" type="checkbox" value="1" @checked(old('terms_accepted')) required>
                    <span>
                        I agree to the
                        <a href="{{ url('/privacy-policy') }}" target="_blank" rel="noreferrer">Privacy Policy</a>
                        and
                        <a href="{{ url('/terms-of-service') }}" target="_blank" rel="noreferrer">Terms of Service</a>.
                    </span>
                </label>
                @error('terms_accepted')
                    <p class="form-error">{{ $message }}</p>
                @enderror

                @if (filled($turnstileSiteKey))
                    <div class="turnstile-field">
                        <div class="cf-turnstile" data-sitekey="{{ $turnstileSiteKey }}"></div>
                    </div>
                @endif
                @error('cf-turnstile-response')
                    <p class="form-error">{{ $message }}</p>
                @enderror

                <button class="get-started-submit btn-primary" type="submit" data-submit-label="Starting trial…">
                    <span data-submit-text>Start free trial</span>
                </button>
            </aside>
        </form>
    </section>
@endsection
