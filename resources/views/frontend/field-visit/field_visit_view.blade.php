@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .textarea-margin {
            margin-bottom: 20px;
        }
    </style>

    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> : {{ Helpers::getDivisionName(session()->get('division')) }} / Field
            Visit
            Survey
        </div>
    </div>

    <style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            text-align: center;
            position: relative;
            /* border-right: none; */
            background: white;
        }

        .state-block {
            padding: 20px;
            margin-bottom: 20px;
        }

        .progress-bars div.active {
            background: green;
            font-weight: bold;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
            border-radius: 20px 0px 0px 20px;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(3) {
            border-radius: 0px 20px 20px 0px;

        }

        .hide-input {
            display: none;
        }
    </style>
    @php
        $users = DB::table('users')->select('id', 'name')->get();
    @endphp

    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>
                    @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 1])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <div class="d-flex" style="gap:20px;">
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <a class="text-white" href="{{ url('field_visit_auditTrail', $data->id) }}"><button
                                class="button_theme1"> Audit Trail </button></a>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(10, $userRoleIds) || in_array(18, $userRoleIds) || in_array(13, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review Completed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                        @endif
                        <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"><button class="button_theme1"> Exit
                            </button> </a>
                    </div>
                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By nilesh-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($data->stage >= 2)
                                <div class="active">Pending Review</div>
                            @else
                                <div class="">Pending Review</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                        </div>
                    @endif
                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Ambience</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Staff Observation</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">CFT</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Sale / Marketing Strategy</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Product Observation </button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">VM & Space Management</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Branding</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">Trial Rooms</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Activity Log</button>
            </div>

            <form action="{{ route('field_visit_update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="step-form">
                    {{-- @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif --}}
                    <!-- -----------Tab-1------------ -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Parent Record Information</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number">Record Number</label>
                                        <input disabled type="text" name="record"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/FVS/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code">Site/Location Code</label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">QMS-North America</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator">Initiator</label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Date of Initiation</label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        @if (isset($data) && $data->intiation_date)
                                            <input disabled type="text"
                                                value="{{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}"
                                                name="intiation_date_display">
                                        @else
                                            <input disabled type="text" value="" name="intiation_date_display">
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date">Date</label>
                                        <input type="date" value="{{ date('d-M-Y') }}" name="date">
                                        <!-- <input type="date" name="date"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')"  /> -->

                                    </div>
                                </div> --}}

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Date <span class="text-danger"></span></label>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY"
                                                value="{{ Helpers::getdateFormat($data->date) }}" />
                                            <input type="date" name="date" value="" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Time">Time</label>
                                        <input type="time" value="{{ $data->time }}" name="time">
                                        {{-- <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date"> --}}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description"
                                            value="{{ $data->short_description }}" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Brand Name">
                                            Brand Name<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="brand_name">
                                            <option value="">Select a value</option>
                                            <option value="W "{{ $data->brand_name == 'W' ? 'selected' : '' }}>W
                                            </option>
                                            <option
                                                value="Aurelia "{{ $data->brand_name == 'Aurelia' ? 'selected' : '' }}>
                                                Aurelia</option>
                                            <option
                                                value="Jaypore "{{ $data->brand_name == 'Jaypore' ? 'selected' : '' }}>
                                                Jaypore</option>
                                            <option
                                                value="Global Desi "{{ $data->brand_name == 'Global Desi' ? 'selected' : '' }}>
                                                Global Desi</option>
                                            <option
                                                value="FAB India "{{ $data->brand_name == 'FAB India' ? 'selected' : '' }}>
                                                FAB India</option>
                                            <option value="BIBA "{{ $data->brand_name == 'BIBA' ? 'selected' : '' }}>BIBA
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Name of field visitor">
                                            Name of field visitor<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="field_visitor">
                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option {{ $data->field_visitor == $value->name ? 'selected' : '' }}
                                                        value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('field_visitor')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select name="assign_to" onchange="">
                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option {{ $data->assign_to == $value->name ? 'selected' : '' }}
                                                        value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="REGION">
                                            Region<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="region">
                                            <option value="">Select a value</option>
                                            <option
                                                value="Extension Of South Mumbai - Prabhadevi to Mahim"{{ $data->region == 'Extension Of South Mumbai - Prabhadevi to Mahim' ? 'selected' : '' }}>
                                                Extension Of South Mumbai - Prabhadevi to Mahim</option>
                                            <option
                                                value="Western Suburbs (A) - Bandra to Santacruz"{{ $data->region == 'Western Suburbs (A) - Bandra to Santacruz' ? 'selected' : '' }}>
                                                Western Suburbs (A) - Bandra to Santacruz</option>
                                            <option
                                                value="Western Suburbs (B)- Ville Parle to Andheri"{{ $data->region == 'Western Suburbs (B)- Ville Parle to Andheri' ? 'selected' : '' }}>
                                                Western Suburbs (B)- Ville Parle to Andheri</option>
                                            <option
                                                value="Western Suburbs (C) - Jogeshwari to Goregoan"{{ $data->region == 'Western Suburbs (C) - Jogeshwari to Goregoan' ? 'selected' : '' }}>
                                                Western Suburbs (C) - Jogeshwari to Goregoan</option>
                                            <option
                                                value="Western Suburbs (D) - Malad to Borivali"{{ $data->region == 'Western Suburbs (D) - Malad to Borivali' ? 'selected' : '' }}>
                                                Western Suburbs (D) - Malad to Borivali</option>
                                            <option
                                                value="North Mumbai - Beyond Borivali up to Virar"{{ $data->region == 'North Mumbai - Beyond Borivali up to Virar' ? 'selected' : '' }}>
                                                North Mumbai - Beyond Borivali up to Virar</option>
                                            <option
                                                value="Eastern Suburbs - Central Mumbai"{{ $data->region == 'Eastern Suburbs - Central Mumbai' ? 'selected' : '' }}>
                                                Eastern Suburbs - Central Mumbai</option>
                                            <option
                                                value="Harbour Suburbs - Navi Mumbai"{{ $data->region == 'Harbour Suburbs - Navi Mumbai' ? 'selected' : '' }}>
                                                Harbour Suburbs - Navi Mumbai
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="EXACT LOCATION">
                                            Exact Location<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="exact_location">
                                            <option value="">Select a value</option>
                                            <option
                                                value="Churchgate "{{ $data->exact_location == 'Churchgate' ? 'selected' : '' }}>
                                                Churchgate</option>
                                            <option
                                                value="Marine Lines "{{ $data->exact_location == 'Marine Lines' ? 'selected' : '' }}>
                                                Marine Lines</option>
                                            <option
                                                value="Charni Roads "{{ $data->exact_location == 'Charni Roads' ? 'selected' : '' }}>
                                                Charni Roads</option>
                                            <option
                                                value="Grant Roads "{{ $data->exact_location == 'Grant Roads' ? 'selected' : '' }}>
                                                Grant Roads</option>
                                            <option
                                                value="Mumbai Central "{{ $data->exact_location == 'Mumbai Central' ? 'selected' : '' }}>
                                                Mumbai Central</option>
                                            <option
                                                value="Worli "{{ $data->exact_location == 'Worli' ? 'selected' : '' }}>
                                                Worli</option>
                                            <option
                                                value="Lower Parel "{{ $data->exact_location == 'Lower Parel' ? 'selected' : '' }}>
                                                Lower Parel</option>
                                            <option
                                                value="Dadar "{{ $data->exact_location == 'Dadar' ? 'selected' : '' }}>
                                                Dadar</option>
                                            <option
                                                value="Bandra "{{ $data->exact_location == 'Bandra' ? 'selected' : '' }}>
                                                Bandra</option>
                                            <option
                                                value="Santacruz "{{ $data->exact_location == 'Santacruz' ? 'selected' : '' }}>
                                                Santacruz</option>
                                            <option value="Khar "{{ $data->exact_location == 'Khar' ? 'selected' : '' }}>
                                                Khar</option>
                                            <option
                                                value="Vile Parle "{{ $data->exact_location == 'Vile Parle' ? 'selected' : '' }}>
                                                Vile Parle</option>
                                            <option
                                                value="Andheri "{{ $data->exact_location == 'Andheri' ? 'selected' : '' }}>
                                                Andheri</option>
                                            <option
                                                value="Goregaon "{{ $data->exact_location == 'Goregaon' ? 'selected' : '' }}>
                                                Goregaon</option>
                                            <option
                                                value="Malad "{{ $data->exact_location == 'Malad' ? 'selected' : '' }}>
                                                Malad</option>
                                            <option
                                                value="kandivali "{{ $data->exact_location == 'kandivali' ? 'selected' : '' }}>
                                                kandivali</option>
                                            <option
                                                value="Borivali "{{ $data->exact_location == 'Borivali' ? 'selected' : '' }}>
                                                Borivali</option>
                                            <option
                                                value="Bhayander "{{ $data->exact_location == 'Bhayander' ? 'selected' : '' }}>
                                                Bhayander</option>
                                            <option
                                                value="Seawoods "{{ $data->exact_location == 'Seawoods' ? 'selected' : '' }}>
                                                Seawoods</option>
                                            <option
                                                value="Vashi "{{ $data->exact_location == 'Vashi' ? 'selected' : '' }}>
                                                Vashi</option>
                                            <option
                                                value="Ghatkopar "{{ $data->exact_location == 'Ghatkopar' ? 'selected' : '' }}>
                                                Ghatkopar</option>
                                            <option
                                                value="Thane "{{ $data->exact_location == 'Thane' ? 'selected' : '' }}>
                                                Thane</option>
                                            <option
                                                value="Kalyan "{{ $data->exact_location == 'Kalyan' ? 'selected' : '' }}>
                                                Kalyan</option>
                                            <option
                                                value="Other "{{ $data->exact_location == 'Other' ? 'selected' : '' }}>
                                                Other</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="group-input textarea-margin">
                                    <label class="mt-4" for="EXACT STORE ADDRESS">Exact Store Address</label>
                                    <textarea class="summernote textarea-margin" name="exact_address" id="summernote-16">{{ $data->exact_address }}</textarea>
                                </div>
                            </div>


                            {{-- <div class="group-input">
                                <label class="mt-4" for="EXACT STORE ADDRESS">EXACT STORE ADDRESS</label>
                                <textarea class="summernote" name="QA_Feedbacks" id="summernote-16"></textarea>
                            </div>
                        </div> --}}


                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                {{-- <div class="col-12"> --}}
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- -----------Tab-2------------ -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            {{--
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="PAGE SECTION">
                                                Page Section <span class="text-danger"></span>
                                            </label>
                                            <select id="select-state" placeholder="Select..." name="page_section">
                                                <option value="">Select a value</option>
                                                <option value="AMBIENCE "{{ $data->page_section == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                                <option value="Staff Observation "{{ $data->page_section == 'Staff Observation' ? 'selected' : '' }}>Staff Observation</option>
                                                <option value="Sale / Marketing Strategy "{{ $data->page_section == 'Sale / Marketing Strategy' ? 'selected' : '' }}>Sale / Marketing Strategy</option>
                                                <option value="Product Observation "{{ $data->page_section == 'Product Observation' ? 'selected' : '' }}>Product Observation</option>
                                                <option value="VM & Space Management "{{ $data->page_section == 'VM & Space Management' ? 'selected' : '' }}>VM & Space Management</option>
                                                <option value="Branding "{{ $data->page_section == 'Branding' ? 'selected' : '' }}>Branding</option>
                                                <option value="Trial rooms "{{ $data->page_section == 'Trial rooms' ? 'selected' : '' }}>Trial rooms</option>

                                            </select>
                                        </div>
                                    </div> --}}


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="QA Attachment">Photos (Store From Outside, Racks, Window Display, Overall
                                        VM)
                                    </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="QA_Attachments">
                                            @if ($data->photos)
                                                @foreach (json_decode($data->photos) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="QA_Attachments" name="photos[]"
                                                oninput="addMultipleFiles(this, 'QA_Attachments')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Overall Store Lighting <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_lighting">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->store_lighting == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->store_lighting == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->store_lighting == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->store_lighting == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->store_lighting == '5' ? 'selected' : '' }}>5
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Lighting On Products / Browser Lighting <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="lighting_products">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->lighting_products == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->lighting_products == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->lighting_products == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->lighting_products == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->lighting_products == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Overall Store Vibe <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_vibe">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->store_vibe == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2 "{{ $data->store_vibe == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3 "{{ $data->store_vibe == '3' ? 'selected' : '' }}>3</option>
                                        <option value="4 "{{ $data->store_vibe == '4' ? 'selected' : '' }}>4</option>
                                        <option value="5 "{{ $data->store_vibe == '5' ? 'selected' : '' }}>5</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Fragrance In Store <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="fragrance_in_store">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->fragrance_in_store == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->fragrance_in_store == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->fragrance_in_store == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->fragrance_in_store == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->fragrance_in_store == '5' ? 'selected' : '' }}>5
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Music Inside Store? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="music_inside_store">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->music_inside_store == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->music_inside_store == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->music_inside_store == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->music_inside_store == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->music_inside_store == '5' ? 'selected' : '' }}>5
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Space Utilization <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="space_utilization">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->space_utilization == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->space_utilization == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->space_utilization == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->space_utilization == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->space_utilization == '5' ? 'selected' : '' }}>5
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Store Layout <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_layout">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->store_layout == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->store_layout == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->store_layout == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->store_layout == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->store_layout == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        The Store Is of How Many Floors? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="floors">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->floors == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2 "{{ $data->floors == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3 "{{ $data->floors == '3' ? 'selected' : '' }}>3</option>
                                        <option value="4 "{{ $data->floors == '4' ? 'selected' : '' }}>4</option>
                                        <option value="5 "{{ $data->floors == '5' ? 'selected' : '' }}>5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        AC & Ventilation <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="ac">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->ac == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2 "{{ $data->ac == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3 "{{ $data->ac == '3' ? 'selected' : '' }}>3</option>
                                        <option value="4 "{{ $data->ac == '4' ? 'selected' : '' }}>4</option>
                                        <option value="5 "{{ $data->ac == '5' ? 'selected' : '' }}>5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Mannequin Display <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="mannequin_display">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->mannequin_display == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->mannequin_display == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->mannequin_display == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->mannequin_display == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->mannequin_display == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Seating Area (Inside Store) <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="seating_area">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->seating_area == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->seating_area == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->seating_area == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->seating_area == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->seating_area == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Product Visibility <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="product_visiblity">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->product_visiblity == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->product_visiblity == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->product_visiblity == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->product_visiblity == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->product_visiblity == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Store Signage and Graphics <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_signage">
                                        <option value="">Select a value</option>
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->store_signage == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2 "{{ $data->store_signage == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3 "{{ $data->store_signage == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4 "{{ $data->store_signage == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5 "{{ $data->store_signage == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="OVERALL STORE LIGHTING">
                                        Does The Store Have Independent Washroom ? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="independent_washroom">
                                        <option value="">Select a value</option>
                                        <option value="1 "{{ $data->independent_washroom == '1' ? 'selected' : '' }}>
                                            1</option>
                                        <option value="2 "{{ $data->independent_washroom == '2' ? 'selected' : '' }}>
                                            2</option>
                                        <option value="3 "{{ $data->independent_washroom == '3' ? 'selected' : '' }}>
                                            3</option>
                                        <option value="4 "{{ $data->independent_washroom == '4' ? 'selected' : '' }}>
                                            4</option>
                                        <option value="5 "{{ $data->independent_washroom == '5' ? 'selected' : '' }}>
                                            5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input textarea-margin">
                                <label class="mt-4" for="ANY REMARKS">Any Remarks</label>
                                <p class="text-primary">Mention the flooring, curtains used, if any specific wallpaper /
                                    artistic objects are used to enhance the store vibe. Describe how the articles are kept
                                    on basis of the store (For eg., Left wall has kurtis in colour blocking, right wall has
                                    bottoms in another colour blocking, centre has accessories, end has trial rooms, cash
                                    counter has upselling items etc etc etc). </p>
                                <textarea class="summernote" name="any_remarks" id="summernote-16">{{ $data->any_remarks }}</textarea>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                </a> </button>
                        </div>
                    </div>
                </div>
        </div>






        <!-- -----------Tab-4------------ -->
        <div id="CCForm3" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">
                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="PAGE SECTION">
                                        PAGE SECTION <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section1">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE "{{ $data->page_section1 == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                        <option value="STAFF OBSERVATION "{{ $data->page_section1 == 'STAFF OBSERVATION' ? 'selected' : '' }}>STAFF OBSERVATION</option>
                                        <option value="SALE / MARKETING STRATEGY "{{ $data->page_section1 == 'SALE / MARKETING STRATEGY' ? 'selected' : '' }}>SALE / MARKETING STRATEGY</option>
                                        <option value="PRODUCT OBSERVATION "{{ $data->page_section1 == 'PRODUCT OBSERVATION' ? 'selected' : '' }}>PRODUCT OBSERVATION</option>
                                        <option value="VM & SPACE MANAGEMENT "{{ $data->page_section1 == 'VM & SPACE MANAGEMENT' ? 'selected' : '' }}>VM & SPACE MANAGEMENT</option>
                                        <option value="BRANDING "{{ $data->page_section1 == 'BRANDING' ? 'selected' : '' }}>BRANDING</option>
                                        <option value="TRIAL ROOMS "{{ $data->page_section1 == 'TRIAL ROOMS' ? 'selected' : '' }}>TRIAL ROOMS</option>

                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Staff Behavior ( Initial Staff Behaviour) <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="staff_behaviour">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->staff_behaviour == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->staff_behaviour == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->staff_behaviour == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->staff_behaviour == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->staff_behaviour == '5' ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Well Groomed <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="well_groomed">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->well_groomed == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->well_groomed == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->well_groomed == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->well_groomed == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->well_groomed == '5' ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Standard Staff Uniform <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="standard_staff_uniform">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->standard_staff_uniform == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No "{{ $data->standard_staff_uniform == 'No' ? 'selected' : '' }}>No
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Trial Room Assistance <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="trial_room_assistance">
                                <option value="">Select a value</option>
                                <option value="YES "{{ $data->trial_room_assistance == 'YES' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="NO "{{ $data->trial_room_assistance == 'NO' ? 'selected' : '' }}>No
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                No. of Customer At the Store Currently ? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="number_customer">
                                <option value="">Select a value</option>
                                <option value="0-2 "{{ $data->number_customer == '0-2' ? 'selected' : '' }}>0-2
                                </option>
                                <option value="2-5 "{{ $data->number_customer == '2-5' ? 'selected' : '' }}>2-5
                                </option>
                                <option value="5-7 "{{ $data->number_customer == '5-7' ? 'selected' : '' }}>5-7
                                </option>
                                <option value="Above 7 "{{ $data->number_customer == 'Above 7' ? 'selected' : '' }}>Above
                                    7</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Is the Staff Able to Handle The Customer ? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="handel_customer">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->handel_customer == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No "{{ $data->handel_customer == 'No' ? 'selected' : '' }}>No</option>
                                <option
                                    value="No Customer Seen "{{ $data->handel_customer == 'No Customer Seen' ? 'selected' : '' }}>
                                    No Customer Seen</option>


                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Knowledge of Merchandise <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="knowledge_of_merchandise">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->knowledge_of_merchandise == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->knowledge_of_merchandise == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->knowledge_of_merchandise == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->knowledge_of_merchandise == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->knowledge_of_merchandise == '5' ? 'selected' : '' }}>5
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Awareness of Brand / Offers / In General <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="awareness_of_brand">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->awareness_of_brand == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->awareness_of_brand == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->awareness_of_brand == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->awareness_of_brand == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->awareness_of_brand == '5' ? 'selected' : '' }}>5</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Proactive <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="proactive">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->proactive == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->proactive == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->proactive == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->proactive == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->proactive == '5' ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Overall Customer Satisfaction (Staff Behavior Towards Customer/you) <span
                                    class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="customer_satisfaction">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->customer_satisfaction == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->customer_satisfaction == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->customer_satisfaction == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->customer_satisfaction == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->customer_satisfaction == '5' ? 'selected' : '' }}>5
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Billing Counter Experience <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="billing_counter_experience">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->billing_counter_experience == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->billing_counter_experience == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->billing_counter_experience == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->billing_counter_experience == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->billing_counter_experience == '5' ? 'selected' : '' }}>5
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="ANY REMARKS">Any Remarks on Staff Observation?</label>
                        <p class="text-primary">Describe the staff uniform and anything that requires to be noted down
                            related to the store staff. </p>
                        <textarea class="summernote" name="remarks_on_staff_observation" id="summernote-16">{{ $data->remarks_on_staff_observation }}</textarea>
                    </div>
                </div>


                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                        </a> </button>
                </div>
            </div>
        </div>
        {{-- </div> --}}
        <!-- -----------Tab-4------------ -->

        <div id="CCForm4" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="PAGE SECTION">
                                        PAGE SECTION <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_sacetion_2">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE "{{ $data->page_sacetion_2 == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                        <option value="STAFF OBSERVATION "{{ $data->page_sacetion_2 == 'STAFF OBSERVATION' ? 'selected' : '' }}>STAFF OBSERVATION</option>
                                        <option value="SALE / MARKETING STRATEGY "{{ $data->page_sacetion_2 == 'SALE / MARKETING STRATEGY' ? 'selected' : '' }}>SALE / MARKETING STRATEGY</option>
                                        <option value="PRODUCT OBSERVATION "{{ $data->page_sacetion_2 == 'PRODUCT OBSERVATION' ? 'selected' : '' }}>PRODUCT OBSERVATION</option>
                                        <option value="VM & SPACE MANAGEMENT "{{ $data->page_sacetion_2 == 'VM & SPACE MANAGEMENT' ? 'selected' : '' }}>VM & SPACE MANAGEMENT</option>
                                        <option value="BRANDING "{{ $data->page_sacetion_2 == 'BRANDING' ? 'selected' : '' }}>BRANDING</option>
                                        <option value="TRIAL ROOMS "{{ $data->page_sacetion_2 == 'TRIAL ROOMS' ? 'selected' : '' }}>TRIAL ROOMS</option>

                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Is the Store Currently Running Any Offers Or Discounts? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="any_offers">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->any_offers == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No "{{ $data->any_offers == 'No' ? 'selected' : '' }}>No</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Current Offer In the Overall Store? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="current_offer">
                                <option value="">Select a value</option>
                                <option
                                    value="Upto 20% - 30% OFF "{{ $data->current_offer == 'Upto 20% - 30% OFF' ? 'selected' : '' }}>
                                    Upto 20% - 30% OFF</option>
                                <option
                                    value="Upto 50% - 70% OFF "{{ $data->current_offer == 'Upto 50% - 70% OFF' ? 'selected' : '' }}>
                                    Upto 50% - 70% OFF</option>
                                <option
                                    value="Flat 20% - 30% OFF "{{ $data->current_offer == 'Flat 20% - 30% OFF' ? 'selected' : '' }}>
                                    Flat 20% - 30% OFF</option>
                                <option
                                    value="Flat 50% - 70% OFF "{{ $data->current_offer == 'Flat 50% - 70% OFF' ? 'selected' : '' }}>
                                    Flat 50% - 70% OFF</option>
                                <option value="Buy to Get "{{ $data->current_offer == 'Buy to Get' ? 'selected' : '' }}>
                                    Buy to Get</option>
                                <option value="Other "{{ $data->current_offer == 'Other' ? 'selected' : '' }}>Other
                                </option>
                                <option value="None "{{ $data->current_offer == 'None' ? 'selected' : '' }}>None
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Return/Exchange Policy <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="exchange_policy">
                                <option value="">Select a value</option>
                                <option
                                    value="Only Exchange "{{ $data->exchange_policy == 'Only Exchange' ? 'selected' : '' }}>
                                    Only Exchange</option>
                                <option
                                    value="Exchange Or Return "{{ $data->exchange_policy == 'Exchange Or Return' ? 'selected' : '' }}>
                                    Exchange Or Return</option>
                                <option
                                    value="No Exchange No Return "{{ $data->exchange_policy == 'No Exchange No Return' ? 'selected' : '' }}>
                                    No Exchange No Return</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Personal Occasion Discount Offered? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="discount_offer">
                                <option value="">Select a value</option>
                                <option
                                    value="Birthday Discount "{{ $data->discount_offer == 'Birthday Discount' ? 'selected' : '' }}>
                                    Birthday Discount</option>
                                <option
                                    value="Anniversary Discount "{{ $data->discount_offer == 'Anniversary Discount' ? 'selected' : '' }}>
                                    Anniversary Discount</option>
                                <option
                                    value="Other Ocassion "{{ $data->discount_offer == 'Other Ocassion' ? 'selected' : '' }}>
                                    Other Ocassion</option>
                                <option
                                    value="Premium Member Discount "{{ $data->discount_offer == 'Premium Member Discount' ? 'selected' : '' }}>
                                    Premium Member Discount</option>
                                <option value="None "{{ $data->discount_offer == 'None' ? 'selected' : '' }}>None
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Reward Point Given? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="reward_point_given">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->reward_point_given == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No "{{ $data->reward_point_given == 'No' ? 'selected' : '' }}>No
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Use of Influencer/ Brand Marketing <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="use_of_influencer">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->use_of_influencer == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No "{{ $data->use_of_influencer == 'No' ? 'selected' : '' }}>No
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Age Group of Customers Currently Seen At the Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="age_group_of_customer">
                                <option value="">Select a value</option>
                                <option value="20-25 "{{ $data->age_group_of_customer == '20-25' ? 'selected' : '' }}>
                                    20-25</option>
                                <option value="25-35 "{{ $data->age_group_of_customer == '25-35' ? 'selected' : '' }}>
                                    25-35</option>
                                <option value="35-45 "{{ $data->age_group_of_customer == '35-45' ? 'selected' : '' }}>
                                    35-45</option>
                                <option
                                    value="Above 45 "{{ $data->age_group_of_customer == 'Above 45' ? 'selected' : '' }}>
                                    Above 45</option>
                                <option
                                    value="No Customers Seen "{{ $data->age_group_of_customer == 'No Customers Seen' ? 'selected' : '' }}>
                                    No Customers Seen</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Alteration Facility In Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="alteration_facility_in_store">
                                <option value="">Select a value</option>
                                <option
                                    value="Available "{{ $data->alteration_facility_in_store == 'Available' ? 'selected' : '' }}>
                                    Available</option>
                                <option
                                    value="Not Available "{{ $data->alteration_facility_in_store == 'Not Available' ? 'selected' : '' }}>
                                    Not Available</option>

                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="ANY REMARKS">Any Remarks Sale / Marketing Strategy?</label>
                        <p class="text-primary">Mention the offers if any. Also mention reward points rule. Describe if you
                            feel anything is out of the box about marketing and sales strategy observed in this brand.
                            Mention exchange days/deadline. </p>
                        <textarea class="summernote" name="any_remarks_sale" id="summernote-16">{{ $data->any_remarks_sale }}</textarea>
                    </div>
                </div>



                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                        </a> </button>
                </div>
            </div>
        </div>

        <!-- -----------Tab-5------------ -->
        <div id="CCForm5" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="PAGE SECTION">
                                        PAGE SECTION <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_3">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE "{{ $data->page_section_3 == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                        <option value="STAFF OBSERVATION "{{ $data->page_section_3 == 'STAFF OBSERVATION' ? 'selected' : '' }}>STAFF OBSERVATION</option>
                                        <option value="SALE / MARKETING STRATEGY "{{ $data->page_section_3 == 'SALE / MARKETING STRATEGY' ? 'selected' : '' }}>SALE / MARKETING STRATEGY</option>
                                        <option value="PRODUCT OBSERVATION "{{ $data->page_section_3 == 'PRODUCT OBSERVATION' ? 'selected' : '' }}>PRODUCT OBSERVATION</option>
                                        <option value="BRANDING "{{ $data->page_section_3 == 'BRANDING' ? 'selected' : '' }}>BRANDING</option>
                                        <option value="TRIAL ROOMS "{{ $data->page_section_3 == 'TRIAL ROOMS' ? 'selected' : '' }}>TRIAL ROOMS</option>
                                        <option value="VM & SPACE MANAGEMENT "{{ $data->page_section_3 == 'VM & SPACE MANAGEMENT' ? 'selected' : '' }}>VM & SPACE MANAGEMENT</option>

                                    </select>
                                </div>
                            </div> --}}


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Sub-brands Offered? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="sub_brand_offered">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->sub_brand_offered == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No "{{ $data->sub_brand_offered == 'No' ? 'selected' : '' }}>No
                                </option>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Colour Palette of the Entire Store At First Sight <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="colour_palette">
                                <option value="">Select a value</option>
                                <option
                                    value="Light/Pastel "{{ $data->colour_palette == 'Light/Pastel' ? 'selected' : '' }}>
                                    Light/Pastel</option>
                                <option value="Dark/Dull "{{ $data->colour_palette == 'Dark/Dull' ? 'selected' : '' }}>
                                    Dark/Dull</option>
                                <option
                                    value="Mix Equally "{{ $data->colour_palette == 'Mix Equally' ? 'selected' : '' }}>
                                    Mix Equally</option>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Number of Colourways Offered In Most Styles <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="number_of_colourways">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->awareness_of_brand == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->awareness_of_brand == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->awareness_of_brand == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->awareness_of_brand == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->awareness_of_brand == '5' ? 'selected' : '' }}>5</option>


                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Size Availability <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="size_availiblity">
                                <option value="">Select a value</option>
                                <option value="XXS "{{ $data->size_availiblity == 'XXS' ? 'selected' : '' }}>XXS
                                </option>
                                <option value="XS "{{ $data->size_availiblity == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S "{{ $data->size_availiblity == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M "{{ $data->size_availiblity == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L "{{ $data->size_availiblity == 'L' ? 'seXLected' : '' }}>L</option>
                                <option value="XL "{{ $data->size_availiblity == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="2XL "{{ $data->size_availiblity == '2XL' ? 'selected' : '' }}>2XL
                                </option>
                                <option value="3XL "{{ $data->size_availiblity == '3XL' ? 'selected' : '' }}>3XL
                                </option>
                                <option value="4XL "{{ $data->size_availiblity == '4XL' ? 'selected' : '' }}>4XL
                                </option>
                                <option value="5XL "{{ $data->size_availiblity == '5XL' ? 'selected' : '' }}>5XL
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Details G-1
                            <button type="button" name="details" id="Details1-add">+</button>
                            <span class="text-primary" data-bs-toggle="modal"
                                data-bs-target="#observation-field-instruction-modal"
                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Details1-table">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">Row#</th>
                                        <th style="width: 16%">Category</th>
                                        <th style="width: 16%">Price</th>
                                        <th style="width: 5%">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($grid_Data && is_array($grid_Data->data))
                                        @foreach ($grid_Data->data as $datas)
                                            <tr>
                                                <td><input disabled type="text"
                                                        name="details1[{{ $loop->index }}][row]" value="1"></td>
                                                <td>
                                                    <select name="details1[{{ $loop->index }}][category]">
                                                        <option value="">--Select Category--</option>
                                                        <option value="Single Kurta"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Single Kurta' ? 'selected' : '' }}>
                                                            Single Kurta</option>
                                                        <option value="Kurta Sets"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Kurta Sets' ? 'selected' : '' }}>
                                                            Kurta Sets</option>
                                                        <option value="Shirts / Tunics"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Shirts / Tunics' ? 'selected' : '' }}>
                                                            SHIRTS / TUNICS</option>
                                                        <option value="Short Dresses"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Short Dresses' ? 'selected' : '' }}>
                                                            Short Dresses</option>
                                                        <option value="Long Dresses"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Long Dresses' ? 'selected' : '' }}>
                                                            Long Dresses</option>
                                                        <option value="Bottoms"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Bottoms' ? 'selected' : '' }}>
                                                            Bottoms</option>
                                                        <option value="Indo-western Co-ord Set"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Indo-western Co-ord Set' ? 'selected' : '' }}>
                                                            Indo-western Co-ord Set</option>
                                                        <option value="Jumpsuit"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Jumpsuit' ? 'selected' : '' }}>
                                                            Jumpsuit</option>
                                                        <option value="Dupattas"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Dupattas' ? 'selected' : '' }}>
                                                            Dupattas</option>
                                                        <option value="Lehenga"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Lehenga' ? 'selected' : '' }}>
                                                            Lehenga</option>
                                                        <option value="Saree"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Saree' ? 'selected' : '' }}>
                                                            Saree</option>
                                                        <option value="Jackets & Shrugs"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Jackets & Shrugs' ? 'selected' : '' }}>
                                                            Jackets & Shrugs</option>
                                                        <option value="Dress Material"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Dress Material' ? 'selected' : '' }}>
                                                            Dress Material</option>
                                                        <option value="Footwear"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Footwear' ? 'selected' : '' }}>
                                                            Footwear</option>
                                                        <option value="Jewellry"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Jewellry' ? 'selected' : '' }}>
                                                            Jewellry</option>
                                                        <option value="Handbags"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Handbags' ? 'selected' : '' }}>
                                                            Handbags</option>
                                                        <option value="Fragrances"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Fragrances' ? 'selected' : '' }}>
                                                            Fragrances</option>
                                                        <option value="Shawl/ Stole / Scarves"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Shawl/ Stole / Scarves' ? 'selected' : '' }}>
                                                            Shawl/ Stole / Scarves</option>
                                                        <option value="Night Suits"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Night Suits' ? 'selected' : '' }}>
                                                            Night Suits</option>
                                                        <option value="Belts & Wallets"
                                                            {{ isset($datas['category']) && $datas['category'] == 'Belts & Wallets' ? 'selected' : '' }}>
                                                            Belts & Wallets</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="details1[{{ $loop->index }}][price]">
                                                        <option value="">--Select Price--</option>
                                                        <option value="Below 500"
                                                            {{ isset($datas['price']) && $datas['price'] == 'Below 500' ? 'selected' : '' }}>
                                                            Below 500</option>
                                                        <option value="500-2000"
                                                            {{ isset($datas['price']) && $datas['price'] == '500-2000' ? 'selected' : '' }}>
                                                            500-2000</option>
                                                        <option value="2100-5000"
                                                            {{ isset($datas['price']) && $datas['price'] == '2100-5000' ? 'selected' : '' }}>
                                                            2100-5000</option>
                                                        <option value="5100-7000"
                                                            {{ isset($datas['price']) && $datas['price'] == '5100-7000' ? 'selected' : '' }}>
                                                            5100-7000</option>
                                                        <option value="7100-9000"
                                                            {{ isset($datas['price']) && $datas['price'] == '7100-9000' ? 'selected' : '' }}>
                                                            7100-9000</option>
                                                        <option value="9100-15000"
                                                            {{ isset($datas['price']) && $datas['price'] == '9100-15000' ? 'selected' : '' }}>
                                                            9100-15000</option>
                                                        <option value="15100 & Above"
                                                            {{ isset($datas['price']) && $datas['price'] == '15100 & Above' ? 'selected' : '' }}>
                                                            15100 & Above</option>
                                                        <option value="N/A"
                                                            {{ isset($datas['price']) && $datas['price'] == 'N/A' ? 'selected' : '' }}>
                                                            N/A</option>
                                                    </select>
                                                </td>
                                                <td><button type="button" class="removeRowBtn">Remove</button></td>
                                            </tr>
                                        @endforeach
                                    @endif


                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Did You Find Engaging Priced Merchandise At the Store Front ?
                            </label>
                            <select id="select-state" placeholder="Select..." name="engaging_price">
                                <option value="">Select a value</option>
                                <option
                                    value="Lower Priced Items Were Displayed At the Store Front "{{ $data->engaging_price == 'Lower Priced Items Were Displayed At the Store Front' ? 'selected' : '' }}>
                                    Lower Priced Items Were Displayed At the Store Front</option>
                                <option
                                    value="Heigher Priced Items Were Displayed At the Store Front "{{ $data->engaging_price == 'Heigher Priced Items Were Displayed At the Store Front' ? 'selected' : '' }}>
                                    Heigher Priced Items Were Displayed At the Store Front</option>
                                <option
                                    value="Mix Priced Items Were Displayed At the Store Front "{{ $data->engaging_price == 'Mix Priced Items Were Displayed At the Store Front' ? 'selected' : '' }}>
                                    Mix Priced Items Were Displayed At the Store Front</option>
                                <option
                                    value="Discount / Sale Priced Items Were Displayed At the Store Front "{{ $data->engaging_price == 'Discount / Sale Priced Items Were Displayed At the Store Front' ? 'selected' : '' }}>
                                    Discount / Sale Priced Items Were Displayed At the Store Front</option>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Merchandise Availble In the Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="merchadise_available">
                                <option value="">Select a value</option>
                                <option value="Apparel "{{ $data->merchadise_available == 'Apparel' ? 'selected' : '' }}>
                                    Apparel</option>
                                <option value="Apparel "{{ $data->merchadise_available == 'Apparel' ? 'selected' : '' }}>
                                    Apparel</option>
                                <option
                                    value="Footwear "{{ $data->merchadise_available == 'Footwear' ? 'selected' : '' }}>
                                    Footwear</option>
                                <option
                                    value="Cosmetics & Skincare "{{ $data->merchadise_available == 'Cosmetics & Skincare' ? 'selected' : '' }}>
                                    Cosmetics & Skincare</option>
                                <option
                                    value="Home Decor "{{ $data->merchadise_available == 'Home Decor' ? 'selected' : '' }}>
                                    Home Decor</option>
                                <option
                                    value="Accessories "{{ $data->merchadise_available == 'Accessories' ? 'selected' : '' }}>
                                    Accessories</option>
                                <option value="Others"{{ $data->merchadise_available == 'Others' ? 'selected' : '' }}>
                                    Others</option>

                            </select>
                        </div>
                    </div>



                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Details G-2
                            <button type="button" name="details" id="Details2-add">+</button>
                            <span class="text-primary" data-bs-toggle="modal"
                                data-bs-target="#observation-field-instruction-modal"
                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Details2-table">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">Row#</th>
                                        <th style="width: 16%">Styles</th>
                                        <th style="width: 16%">Category</th>
                                        <th style="width: 5%">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($grid_Data2 && is_array($grid_Data2->data))
                                        @foreach ($grid_Data2->data as $names)
                                            <tr>
                                                <td><input disabled type="text"
                                                        name="details2[{{ $loop->index }}][row]" value="1"></td>
                                                <td>
                                                    <select name="details2[{{ $loop->index }}][styles]">
                                                        <option value="">--Select Styles--</option>
                                                        <option value="Casual Wear"
                                                            {{ isset($names['styles']) && $names['styles'] == 'Casual Wear' ? 'selected' : '' }}>
                                                            Casual Wear</option>
                                                        <option value="Traditional/contemporary Wear"
                                                            {{ isset($names['styles']) && $names['styles'] == 'Traditional/contemporary Wear' ? 'selected' : '' }}>
                                                            Traditional/contemporary Wear</option>
                                                        <option value="Ethnic Wear"
                                                            {{ isset($names['styles']) && $names['styles'] == 'Ethnic Wear' ? 'selected' : '' }}>
                                                            Ethnic Wear</option>
                                                        <option value="Short Dresses"
                                                            {{ isset($names['styles']) && $names['styles'] == 'Short Dresses' ? 'selected' : '' }}>
                                                            Short Dresses</option>
                                                        <option value="Indo-western Wear"
                                                            {{ isset($names['styles']) && $names['styles'] == 'Indo-western Wear' ? 'selected' : '' }}>
                                                            Indo-western Wear</option>
                                                        <option value="Designer/Occasion Wear"
                                                            {{ isset($names['styles']) && $names['styles'] == 'Designer/Occasion Wear' ? 'selected' : '' }}>
                                                            Designer/Occasion Wear</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="details2[{{ $loop->index }}][category]">
                                                        <option value="">--Select category--</option>
                                                        <option value="Top/Tunics/Shirts"
                                                            {{ isset($names['category']) && $names['category'] == 'Top/Tunics/Shirts' ? 'selected' : '' }}>
                                                            Top/Tunics/Shirts</option>
                                                        <option value="Skirt/Lehenga"
                                                            {{ isset($names['category']) && $names['category'] == 'Skirt/Lehenga' ? 'selected' : '' }}>
                                                            Skirt/Lehenga</option>
                                                        <option value="Shirts/Tunics"
                                                            {{ isset($names['category']) && $names['category'] == 'Shirts/Tunics' ? 'selected' : '' }}>
                                                            Shirts/Tunics</option>
                                                        <option value="Dresses/Gowns"
                                                            {{ isset($names['category']) && $names['category'] == 'Dresses/Gowns' ? 'selected' : '' }}>
                                                            Dresses/Gowns</option>
                                                        <option value="Palazzo/Pants/Sharara/Leggings"
                                                            {{ isset($names['category']) && $names['category'] == 'Palazzo/Pants/Sharara/Leggings' ? 'selected' : '' }}>
                                                            Palazzo/Pants/Sharara/Leggings</option>
                                                        <option value="Kurtis/Kurta"
                                                            {{ isset($names['category']) && $names['category'] == 'Kurtis/Kurta' ? 'selected' : '' }}>
                                                            Kurtis/Kurta</option>
                                                        <option value="CO-ORD Sets"
                                                            {{ isset($names['category']) && $names['category'] == 'CO-ORD Sets' ? 'selected' : '' }}>
                                                            CO-ORD Sets</option>
                                                        <option value="Saree"
                                                            {{ isset($names['category']) && $names['category'] == 'Saree' ? 'selected' : '' }}>
                                                            Saree</option>
                                                        <option value="Jumpsuit"
                                                            {{ isset($names['category']) && $names['category'] == 'Jumpsuit' ? 'selected' : '' }}>
                                                            Jumpsuit</option>
                                                        <option value="Dupatta/Scarf/Shawl"
                                                            {{ isset($names['category']) && $names['category'] == 'Dupatta/Scarf/Shawl' ? 'selected' : '' }}>
                                                            Dupatta/Scarf/Shawl</option>
                                                        <option value="Dress Material"
                                                            {{ isset($names['category']) && $names['category'] == 'Dress Material' ? 'selected' : '' }}>
                                                            Dress Material</option>
                                                        <option value="Other"
                                                            {{ isset($names['category']) && $names['category'] == 'Other' ? 'selected' : '' }}>
                                                            Other</option>
                                                        <option value="N/A"
                                                            {{ isset($names['category']) && $names['category'] == 'N/A' ? 'selected' : '' }}>
                                                            N/A</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="removeRowBtn">Remove</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>

                            </table>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Types of Fabric Available ? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="types_of_fabric">
                                <option value="">Select a value</option>
                                <option
                                    value="100% Cotton "{{ $data->types_of_fabric == '100% Cotton' ? 'selected' : '' }}>
                                    100% Cotton</option>
                                <option
                                    value="100% Polyster "{{ $data->types_of_fabric == '100% Polyster' ? 'selected' : '' }}>
                                    100% Polyster</option>
                                <option
                                    value="100% Viscose "{{ $data->types_of_fabric == '100% Viscose' ? 'selected' : '' }}>
                                    100% Viscose</option>
                                <option
                                    value="Cotton Poly Blend "{{ $data->types_of_fabric == 'Cotton Poly Blend' ? 'selected' : '' }}>
                                    Cotton Poly Blend</option>
                                <option
                                    value="100% Linen "{{ $data->types_of_fabric == '100% Linen' ? 'selected' : '' }}>
                                    100% Linen</option>
                                <option
                                    value="Viscose Blend "{{ $data->types_of_fabric == 'Viscose Blend' ? 'selected' : '' }}>
                                    Viscose Blend</option>
                                <option value="Silk "{{ $data->types_of_fabric == 'Silk' ? 'selected' : '' }}>Silk
                                </option>
                                <option
                                    value="Polyster Blend "{{ $data->types_of_fabric == 'Polyster Blend' ? 'selected' : '' }}>
                                    Polyster Blend</option>
                                <option
                                    value="Chiffon / Georgette "{{ $data->types_of_fabric == 'Chiffon / Georgette' ? 'selected' : '' }}>
                                    Chiffon / Georgette</option>
                                <option
                                    value="Linen Blend "{{ $data->types_of_fabric == 'Linen Blend' ? 'selected' : '' }}>
                                    Linen Blend</option>
                                <option value="Others "{{ $data->types_of_fabric == 'Others' ? 'selected' : '' }}>Others
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Prints Observed? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="prints_observed">
                                <option value="">Select a value</option>
                                <option
                                    value="Small Floral Prints "{{ $data->prints_observed == 'Small Floral Prints' ? 'selected' : '' }}>
                                    Small Floral Prints</option>
                                <option
                                    value="Big Floral Prints "{{ $data->prints_observed == 'Big Floral Prints' ? 'selected' : '' }}>
                                    Big Floral Prints</option>
                                <option
                                    value="Geometric Prints "{{ $data->prints_observed == 'Geometric Prints' ? 'selected' : '' }}>
                                    Geometric Prints</option>
                                <option
                                    value="Aztec Prints "{{ $data->prints_observed == 'Aztec Prints' ? 'selected' : '' }}>
                                    Aztec Prints</option>
                                <option
                                    value="Traditional Prints (Paisley / Elephant Motifs Etc) "{{ $data->prints_observed == 'Traditional Prints (Paisley / Elephant Motifs Etc)' ? 'selected' : '' }}>
                                    Traditional Prints (Paisley / Elephant Motifs Etc)</option>
                                <option
                                    value="Painting Prints "{{ $data->prints_observed == 'Painting Prints' ? 'selected' : '' }}>
                                    Painting Prints</option>
                                <option
                                    value="Animal Prints "{{ $data->prints_observed == 'Animal Prints' ? 'selected' : '' }}>
                                    Animal Prints</option>
                                <option
                                    value="Abstract Prints "{{ $data->prints_observed == 'Abstract Prints' ? 'selected' : '' }}>
                                    Abstract Prints</option>
                                <option
                                    value="All Over Print "{{ $data->prints_observed == 'All Over Print' ? 'selected' : '' }}>
                                    All Over Print</option>
                                <option
                                    value="Placement Print "{{ $data->prints_observed == 'Placement Print' ? 'selected' : '' }}>
                                    Placement Print</option>
                                <option value="Others "{{ $data->prints_observed == 'Others' ? 'selected' : '' }}>Others
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Embroideries Observed? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="embroideries_observed">
                                <option value="">Select a value</option>
                                <option
                                    value="Thread Work "{{ $data->embroideries_observed == 'Thread Work' ? 'selected' : '' }}>
                                    Thread Work</option>
                                <option
                                    value="Applique "{{ $data->embroideries_observed == 'Applique' ? 'selected' : '' }}>
                                    Applique</option>
                                <option
                                    value="Bead Work "{{ $data->embroideries_observed == 'Bead Work' ? 'selected' : '' }}>
                                    Bead Work</option>
                                <option
                                    value="Stone Work and Zardozi Embroidery "{{ $data->embroideries_observed == 'Stone Work and Zardozi Embroidery' ? 'selected' : '' }}>
                                    Stone Work and Zardozi Embroidery</option>
                                <option
                                    value="Home Decor "{{ $data->embroideries_observed == 'Home Decor' ? 'selected' : '' }}>
                                    Home Decor</option>
                                <option
                                    value="All Over Embroidery "{{ $data->embroideries_observed == 'All Over Embroidery' ? 'selected' : '' }}>
                                    All Over Embroidery</option>
                                <option
                                    value="Placement Embroidery "{{ $data->embroideries_observed == 'Placement Embroidery' ? 'selected' : '' }}>
                                    Placement Embroidery</option>
                                <option value="Others "{{ $data->embroideries_observed == 'Others' ? 'selected' : '' }}>
                                    Others</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Overall Quality of Garments In the Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="quality_of_garments">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->quality_of_garments == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->quality_of_garments == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->quality_of_garments == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->quality_of_garments == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->quality_of_garments == '5' ? 'selected' : '' }}>5
                                </option>


                            </select>
                        </div>
                    </div>


                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="ANY REMARKS">Any Remarks On Product Observation?</label>
                        <p class="text-primary">Mention any sub brands if offered, and anything worth to be noted in this
                            section. </p>
                        <textarea class="summernote" name="remarks_on_product_observation" id="summernote-16">{{ $data->remarks_on_product_observation }}</textarea>
                    </div>
                </div>


                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                        </a> </button>
                </div>
            </div>
        </div>



        <div id="CCForm6" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">


                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="PAGE SECTION">
                                        PAGE SECTION <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_4">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE "{{ $data->page_section_4 == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                        <option value="STAFF OBSERVATION "{{ $data->page_section_4 == 'STAFF OBSERVATION' ? 'selected' : '' }}>STAFF OBSERVATION</option>
                                        <option value="SALE / MARKETING STRATEGY "{{ $data->page_section_4 == 'SALE / MARKETING STRATEGY' ? 'selected' : '' }}>SALE / MARKETING STRATEGY</option>
                                        <option value="PRODUCT OBSERVATION "{{ $data->page_section_4 == 'PRODUCT OBSERVATION' ? 'selected' : '' }}>PRODUCT OBSERVATION</option>
                                        <option value="VM & SPACE MANAGEMENT "{{ $data->page_section_4 == 'VM & SPACE MANAGEMENT' ? 'selected' : '' }}>VM & SPACE MANAGEMENT</option>
                                        <option value="BRANDING "{{ $data->page_section_4 == 'BRANDING' ? 'selected' : '' }}>BRANDING</option>
                                        <option value="TRIAL ROOMS "{{ $data->page_section_4 == 'TRIAL ROOMS' ? 'selected' : '' }}>TRIAL ROOMS</option>

                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                The Entrance of the Store (Display of Garments) <span class="text-danger"></span>
                            </label>
                            <p class="text-primary">Here, mention how you feel about the store from outside at the first
                                glance. Keep in mind if the store visually invites you in or not through colour blocking or
                                mannequin display or anything else.</p>
                            <select id="select-state" placeholder="Select..." name="entrance_of_the_store">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->entrance_of_the_store == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->entrance_of_the_store == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->entrance_of_the_store == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->entrance_of_the_store == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->entrance_of_the_store == '5' ? 'selected' : '' }}>5
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Story Telling <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="story_telling">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->story_telling == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->story_telling == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->story_telling == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->story_telling == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->story_telling == '5' ? 'selected' : '' }}>5</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Stock Display In the Entire Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="stock_display">
                                <option value="">Select a value</option>
                                <option
                                    value="Limited Sizes Are Displayed On Racks "{{ $data->stock_display == 'Limited Sizes Are Displayed On Racks' ? 'selected' : '' }}>
                                    Limited Sizes Are Displayed On Racks</option>
                                <option
                                    value="All Sizes Are Displayed Together On the Same Rack "{{ $data->stock_display == 'All Sizes Are Displayed Together On the Same Rack' ? 'selected' : '' }}>
                                    All Sizes Are Displayed Together On The Same Rack</option>
                                <option
                                    value="All Sizes Are Displayed But On Different Racks "{{ $data->stock_display == 'All Sizes Are Displayed But On Different Racks' ? 'selected' : '' }}>
                                    All Sizes Are Displayed But On Different Racks</option>
                                <option value="Others "{{ $data->stock_display == 'Others' ? 'selected' : '' }}>Others
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Spacing of Clothes On The Rack<span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="spacing_of_clothes">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->spacing_of_clothes == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->spacing_of_clothes == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->spacing_of_clothes == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->spacing_of_clothes == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->spacing_of_clothes == '5' ? 'selected' : '' }}>5
                                </option>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                How Many No. of Customers Can Browse At One Time In One Section?<span
                                    class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="how_many_no_of_customers">
                                <option value="">Select a value</option>
                                <option value="0-2 "{{ $data->how_many_no_of_customers == '0-2' ? 'selected' : '' }}>
                                    0-2</option>
                                <option value="3-4 "{{ $data->how_many_no_of_customers == '3-4' ? 'selected' : '' }}>
                                    3-4</option>
                                <option value="3 "{{ $data->how_many_no_of_customers == '3' ? 'selected' : '' }}>3
                                </option>
                                <option
                                    value="More Than 4 "{{ $data->how_many_no_of_customers == 'More Than 4' ? 'selected' : '' }}>
                                    More Than 4</option>

                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="ANY REMARKS">Any Remarks On VM / Space Management</label>
                        <p class="text-primary">Mention the colours/prints/styles displayed at the entrance of the store,
                            describe the alignment of the store (what's kept on the left side of the store, what's on the
                            right side etc). Also mention if you feel the store is well spaced or not, meaning if the space
                            is properly utilized or over utilized or under utilized. Describe anything else that's relevant
                            to this section. </p>
                        <textarea class="summernote" name="any_remarks_on_vm" id="summernote-16">{{ $data->any_remarks_on_vm }}</textarea>
                    </div>
                </div>


                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                        </a> </button>
                </div>
            </div>
        </div>



        <div id="CCForm7" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="PAGE SECTION">
                                        PAGE SECTION <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_5">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE "{{ $data->page_section_5 == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                        <option value="STAFF OBSERVATION "{{ $data->page_section_5 == 'STAFF OBSERVATION' ? 'selected' : '' }}>STAFF OBSERVATION</option>
                                        <option value="SALE / MARKETING STRATEGY "{{ $data->page_section_5 == 'SALE / MARKETING STRATEGY' ? 'selected' : '' }}>SALE / MARKETING STRATEGY</option>
                                        <option value="PRODUCT OBSERVATION "{{ $data->page_section_5 == 'PRODUCT OBSERVATION' ? 'selected' : '' }}>PRODUCT OBSERVATION</option>
                                        <option value="BRANDING "{{ $data->page_section_5 == 'BRANDING' ? 'selected' : '' }}>BRANDING</option>
                                        <option value="TRIAL ROOMS "{{ $data->page_section_5 == 'TRIAL ROOMS' ? 'selected' : '' }}>TRIAL ROOMS</option>
                                        <option value="VM & SPACE MANAGEMENT "{{ $data->page_section_5 == 'VM & SPACE MANAGEMENT' ? 'selected' : '' }}>VM & SPACE MANAGEMENT</option>

                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Suitable Brand Tagline<span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="brand_tagline">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->brand_tagline == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No "{{ $data->brand_tagline == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Type of Bill<span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="type_of_ball">
                                <option value="">Select a value</option>
                                <option
                                    value="Digital Only "{{ $data->initiated_by == 'Digital Only' ? 'selected' : '' }}>
                                    Digital Only</option>
                                <option
                                    value="Paper Printed Bill "{{ $data->initiated_by == 'Paper Printed Bill' ? 'selected' : '' }}>
                                    Paper Printed Bill</option>
                                <option
                                    value="Digital and Paper Printed Both "{{ $data->initiated_by == 'Digital and Paper Printed Both' ? 'selected' : '' }}>
                                    Digital and Paper Printed Both</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="ANY REMARKS">Any Remarks On Branding?</label>
                        <p class="text-primary">If you see a tagline then mention it here. Add anything else that you feel
                            is worthy to be noted about Branding here. </p>
                        <textarea class="summernote" name="any_ramrks_on_the_branding" id="summernote-16">{{ $data->any_ramrks_on_the_branding }}</textarea>
                    </div>
                </div>



                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                        </a> </button>
                </div>
            </div>
        </div>



        <div id="CCForm8" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="PAGE SECTION">
                                        PAGE SECTION <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_6">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE "{{ $data->initiated_by == 'AMBIENCE' ? 'selected' : '' }}>AMBIENCE</option>
                                        <option value="STAFF OBSERVATION "{{ $data->initiated_by == 'STAFF OBSERVATION' ? 'selected' : '' }}>STAFF OBSERVATION</option>
                                        <option value="SALE / MARKETING STRATEGY "{{ $data->initiated_by == 'SALE / MARKETING STRATEGY' ? 'selected' : '' }}>SALE / MARKETING STRATEGY</option>
                                        <option value="PRODUCT OBSERVATION "{{ $data->initiated_by == 'PRODUCT OBSERVATION' ? 'selected' : '' }}>PRODUCT OBSERVATION</option>
                                        <option value="BRANDING "{{ $data->initiated_by == 'BRANDING' ? 'selected' : '' }}>BRANDING</option>
                                        <option value="TRIAL ROOMS "{{ $data->initiated_by == 'TRIAL ROOMS' ? 'selected' : '' }}>TRIAL ROOMS</option>
                                        <option value="VM & SPACE MANAGEMENT "{{ $data->initiated_by == 'VM & SPACE MANAGEMENT' ? 'selected' : '' }}>VM & SPACE MANAGEMENT</option>

                                    </select>
                                </div>
                            </div> --}}


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Number of Trial Rooms? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="number_of_trial_rooms_">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->number_of_trial_rooms_ == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->number_of_trial_rooms_ == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->number_of_trial_rooms_ == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->number_of_trial_rooms_ == '4' ? 'selected' : '' }}>4
                                </option>
                                <option
                                    value="More Than 4 "{{ $data->number_of_trial_rooms_ == 'More Than 4' ? 'selected' : '' }}>
                                    More Than 4</option>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Hygiene <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="hygiene_">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->hygiene_ == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->hygiene_ == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->hygiene_ == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->hygiene_ == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->hygiene_ == '5' ? 'selected' : '' }}>5</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Ventilation <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="ventilation_">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->ventilation_ == '1' ? 'selected' : '' }}>1</option>
                                <option value="2 "{{ $data->ventilation_ == '2' ? 'selected' : '' }}>2</option>
                                <option value="3 "{{ $data->ventilation_ == '3' ? 'selected' : '' }}>3</option>
                                <option value="4 "{{ $data->ventilation_ == '4' ? 'selected' : '' }}>4</option>
                                <option value="5 "{{ $data->ventilation_ == '5' ? 'selected' : '' }}>5</option>


                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Queue Outside the Trial Room <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="queue_outside_the_trial_room">
                                <option value="">Select a value</option>
                                <option
                                    value="No Queue "{{ $data->queue_outside_the_trial_room == 'No Queue' ? 'selected' : '' }}>
                                    No Queue</option>
                                <option
                                    value="Less Than "{{ $data->queue_outside_the_trial_room == 'Less Than' ? 'selected' : '' }}>
                                    Less Than 2</option>
                                <option
                                    value="people "{{ $data->queue_outside_the_trial_room == 'people' ? 'selected' : '' }}>
                                    2-5 people</option>
                                <option
                                    value="5 and Above "{{ $data->queue_outside_the_trial_room == '5 and Above' ? 'selected' : '' }}>
                                    5 and Above</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Mirror Size <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="mirror_size">
                                <option value="">Select a value</option>
                                <option
                                    value="Full Length - 4 Sides "{{ $data->mirror_size == 'Full Length - 4 Sides' ? 'selected' : '' }}>
                                    Full Length - 4 Sides</option>
                                <option
                                    value="Full Length - 3 Sides "{{ $data->mirror_size == 'Full Length - 3 Sides' ? 'selected' : '' }}>
                                    Full Length - 3 Sides</option>
                                <option
                                    value="Full Length -2 Sides "{{ $data->mirror_size == 'Full Length -2 Sides' ? 'selected' : '' }}>
                                    Full Length -2 Sides</option>
                                <option
                                    value="Full Length - 1 Side "{{ $data->mirror_size == 'Full Length - 1 Side' ? 'selected' : '' }}>
                                    Full Length - 1 Side</option>
                                <option value="Half Mirror "{{ $data->mirror_size == 'Half Mirror' ? 'selected' : '' }}>
                                    Half Mirror</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Trial Room Lighting <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="trial_room_lighting">
                                <option value="">Select a value</option>
                                <option value="1 "{{ $data->trial_room_lighting == '1' ? 'selected' : '' }}>1
                                </option>
                                <option value="2 "{{ $data->trial_room_lighting == '2' ? 'selected' : '' }}>2
                                </option>
                                <option value="3 "{{ $data->trial_room_lighting == '3' ? 'selected' : '' }}>3
                                </option>
                                <option value="4 "{{ $data->trial_room_lighting == '4' ? 'selected' : '' }}>4
                                </option>
                                <option value="5 "{{ $data->trial_room_lighting == '5' ? 'selected' : '' }}>5
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Is Seating Inside the Trail Room Available? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="trial_room_available">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->trial_room_available == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No "{{ $data->trial_room_available == 'No' ? 'selected' : '' }}>No
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Seating Around Trial Room Area (For Companions) <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="seating_around_trial_room">
                                <option value="">Select a value</option>
                                <option
                                    value="Not Available "{{ $data->seating_around_trial_room == 'Not Available' ? 'selected' : '' }}>
                                    Not Available</option>
                                <option
                                    value="1 Seater "{{ $data->seating_around_trial_room == '1 Seater' ? 'selected' : '' }}>
                                    1 Seater</option>
                                <option
                                    value="2 Seater Couch "{{ $data->seating_around_trial_room == '2 Seater Couch' ? 'selected' : '' }}>
                                    2 Seater Couch</option>
                                <option
                                    value="3 Seater Couch "{{ $data->seating_around_trial_room == '3 Seater Couch' ? 'selected' : '' }}>
                                    3 Seater Couch</option>
                                <option
                                    value="Multiple Seater Couch "{{ $data->seating_around_trial_room == 'Multiple Seater Couch' ? 'selected' : '' }}>
                                    Multiple Seater Couch</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="PAGE SECTION">
                                Cloth Hanger Inside the Trial Room Available? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="cloth_hanger">
                                <option value="">Select a value</option>
                                <option value="Yes "{{ $data->cloth_hanger == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No "{{ $data->cloth_hanger == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="ANY REMARKS">Any Remarks On The Trial Room ?</label>
                        <p class="text-primary">Mention the cleanliness and space in the trial room. Also if the trial
                            room has any specific decor like planters or wall displays or anything else.</p>
                        <textarea class="summernote" name="any_remarks_on_the_trail_room" id="summernote-16">{{ $data->any_remarks_on_the_trail_room }}</textarea>
                    </div>
                </div>


                <div class="group-input">
                    <label class="mt-4" for="ANY REMARKS">Any Remarks / Comments Add on The Overall Store?</label>
                    {{-- <p class="text-primary">If you see a tagline then mention it here. Add anything else that you feel is worthy to be noted about Branding here. </p> --}}
                    <textarea class="summernote" name="comments_on_hte_overall_store" id="summernote-16">{{ $data->comments_on_hte_overall_store }}</textarea>
                </div>
            </div>


            <div class="button-block">
                <button type="submit" class="saveButton">Save</button>
                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                    </a> </button>
            </div>
        </div>
        {{-- </div> --}}
        {{-- </div> --}}

        <div id="CCForm9" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Submit By</label>
                            <div class="static">{{ $data->submit_by }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Submit On</label>
                            <div class="static">{{ $data->submit_on }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Comment</label>
                            <div class="static">{{ $data->submit_comment }}</div>
                        </div>
                    </div>
                    <!-- <div> -->
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Review Completed By</label>
                            <div class="static">{{ $data->pending_review_by }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Review Completed On</label>
                            <div class="static">{{ $data->pending_review_on }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Comment</label>
                            <div class="static">{{ $data->pending_review_comment }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">More Info Required By</label>
                            <div class="static">{{ $data->review_completed_more_info_by }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">More Info Required On</label>
                            <div class="static">{{ $data->review_completed_more_info_on }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Comment</label>
                            <div class="static">{{ $data->review_completed_more_info_comment }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Cancel By</label>
                            <div class="static">{{ $data->close_cancel_by }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Cancel On</label>
                            <div class="static">{{ $data->close_cancel_on }}</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Comment</label>
                            <div class="static">{{ $data->close_cancel_comment }}</div>
                        </div>
                    </div>
                </div>



                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                        </a> </button>
                </div>
            </div>
        </div>
    </div>

    </form>

    </div>
    </div>



    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('field_visit_stage', $data->id) }}" method="POST" id="signatureModalForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="signatureModalButton">
                            <div class="spinner-border spinner-border-sm signatureModalSpinner" style="display: none"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="more-info-required-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('field_visit_reject', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input class="more-info" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="more-info" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input class="more-info" type="comment" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                                                                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                        <button>Close</button>
                                                                                    </div> -->
                    <div class="modal-footer">
                        <button type="submit">
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('field_visit_cancel', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                                                                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                        <button>Close</button>
                                                                                    </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        .more-info {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #hod'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

        const saveButtons = document.querySelectorAll(".saveButton");
        const nextButtons = document.querySelectorAll(".nextButton");
        const form = document.getElementById("step-form");
        const stepButtons = document.querySelectorAll(".cctablinks");
        const steps = document.querySelectorAll(".cctabcontent");
        let currentStep = 0;

        function nextStep() {
            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Add active class to next button
                stepButtons[currentStep + 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep++;
            }
        }

        function previousStep() {
            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Add active class to previous button
                stepButtons[currentStep - 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep--;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#Details-add').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html = '';
                    html += '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="details[' + serialNumber +
                        '][ListOfImpactingDocument]"></td>' +
                        '<td><input type="text" name="details[' + serialNumber + '][PreparedBy]"></td>' +
                        // '<td><input type="text" name="details[' + serialNumber + '][PreparedBy]"></td>' +
                        '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    '</tr>';

                    return html;
                }

                var tableBody = $('#Details-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#Details1-add').click(function(e) {
                e.preventDefault();

                function generateOptions(users) {
                    var options = '<option value="">Select a value</option>';
                    users.forEach(function(user) {
                        options += '<option value="' + user.id + '">' + user.name + '</option>';
                    });
                    return options;
                }


                function generateTableRow(serialNumber) {

                    var options = generateOptions(users);

                    var html = '';
                    html += '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '   <td><select type="text" name="details1[' + serialNumber + '][category]">' +
                        '<option value="">--Select Category--</option>' +
                        '<option value="single Kurta">single Kurta</option>' +
                        '<option value="Kurta Sets">KURTA SETS</option>' +
                        '<option value="Shirts/Tunics">Shirts/Tunics</option>' +
                        '<option value="Short Dresses">Short Dresses</option>' +
                        '<option value="Long Dresses">Long Dresses</option>' +
                        '<option value="Bottoms">Bottoms</option>' +
                        '<option value="Indo-Western CO-ORD Set">Indo-Western CO-ORD Set</option>' +
                        '<option value="Jupsuit">Jupsuit</option>' +
                        '<option value="Dupattas">Dupattas</option>' +
                        '<option value="Lehenga">Lehenga</option>' +
                        '<option value="Saree">Saree</option>' +
                        '<option value="Jackets & Shrugs">Jackets & Shrugs</option>' +
                        '<option value="Dress Material">Dress Material</option>' +
                        '<option value="Footwear">Footwear</option>' +
                        '<option value="Jewellary">Jewellary</option>' +
                        '<option value="Handbags">Handbags</option>' +
                        '<option value="Fragrance">Fragrance</option>' +
                        '<option value="Shawl/Stole/Scarves">Shawl/Stole/Scarves</option>' +
                        '<option value="Night Suits">Night Suits</option>' +
                        '<option value="Belt & Wallets">Belt & Wallets</option>' +
                        '</select></td>' +
                        '<td><select type="text" name="details1[' + serialNumber + '][price]">' +
                        '<option value="">--Select Price--</option>' +
                        '<option value="Below 500">Below 500</option>' +
                        '<option value="500-2000">500-2000</option>' +
                        '<option value="2100-5000">2100-5000</option>' +
                        '<option value="5100-7000">5100-7000</option>' +
                        '<option value="7100-9000">7100-9000</option>' +
                        '<option value="9100-15000">9100-15000</option>' +
                        '<option value="15100 & Above">15100 & Above</option>' +
                        '<option value="N/A">N/A</option>' +
                        '</select></td>' +
                        '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +


                    return html;
                }

                var tableBody = $('#Details1-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#Details2-add').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html = '';
                    html += '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '   <td><select type="text" name="details2[' + serialNumber + '][category]">' +
                        '<option value="">--Select Category--</option>' +
                        '<option value="Casual Wear">Casual Wear</option>' +
                        '<option value="Traditional/Contemporary Wear">Traditional/Contemporary Wear</option>' +
                        '<option value="Ethnic Wear">Ethnic Wear</option>' +
                        '<option value="Western Wear">Western Wear</option>' +
                        '<option value="Indo-Western Wear">Indo-Western Wear</option>' +
                        '<option value="Bottoms">Bottoms</option>' +
                        '<option value="Indo_Western CO-ORD Set">Indo_Western CO-ORD Set</option>' +
                        '<option value="Desginer/Occasion wear">Desginer/Occasion wear</option>' +
                        '</select></td>' +
                        '<td><select type="text" name="details2[' + serialNumber + '][price]">' +
                        '<option value="">--Select Price--</option>' +
                        '<option value="Top/Tunics/Shirts">Top/Tunics/Shirts</option>' +
                        '<option value="Skirt/Lehenga">Skirt/Lehenga</option>' +
                        '<option value="Shirts/Tunics">Shirts/Tunics</option>' +
                        '<option value="Dresses/Gowns">Dresses/Gowns</option>' +
                        '<option value="Palazzo/Pants/Sharara/Lesggings">Palazzo/Pants/Sharara/Lesggings</option>' +
                        '<option value="Kurtis/Kurta">Kurtis/Kurta</option>' +
                        '<option value="CO-ORD Sets">CO-ORD Sets</option>' +
                        '<option value="Saree">Saree</option>' +
                        '<option value="Jumpsuit">Jumpsuit</option>' +
                        '<option value="Dupatta/Scarf/Shawl">Dupatta/Scarf/Shawl</option>' +
                        '<option value="Dress Material">Dress Material</option>' +
                        '<option value="Other">Other</option>' +
                        '<option value="N/A">N/A</option>' +

                        '</select></td>' +
                        '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    '</tr>';

                    return html;
                }

                var tableBody = $('#Details2-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.parentElement;

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>

    <script>
        VirtualSelect.init({
            ele: '#reference_record, #notify_to'
        });

        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'italic']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'italic']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        let referenceCount = 1;

        function addReference() {
            referenceCount++;
            let newReference = document.createElement('div');
            newReference.classList.add('row', 'reference-data-' + referenceCount);
            newReference.innerHTML = `
            <div class="col-lg-6">
                <input type="text" name="reference-text">
            </div>
            <div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div><div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div>
        `;
            let referenceContainer = document.querySelector('.reference-data');
            referenceContainer.parentNode.insertBefore(newReference, referenceContainer.nextSibling);
        }
    </script>


    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
@endsection
