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
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }}
            / Field Visit Survey
        </div>

    </div>

    @php
        $users = DB::table('users')->get();
    @endphp



    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

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

            <form action="{{ route('field_visit_store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <!-- -----------Tab-1------------ -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Parent Record Information</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number">Record Number</label>
                                        <input disabled type="text" name="record"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/FVS/{{ date('Y') }}/{{ $record_number }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code">Site/Location Code</label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_code" value="{{ session()->get('division') }}">
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
                                            <input type="hidden" value="{{ $data->intiation_date }}"
                                                name="intiation_date">
                                        @else
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date">Date</label>
                                        <input type="date" value="{{ date('d-M-Y') }}" name="date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="date">
                                    </div>
                                </div> --}}


                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Date <span class="text-danger"></span></label>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                            <input type="date" name="date" value="" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Time">Time</label>
                                        <input type="time" value="" name="time">
                                        {{-- <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date"> --}}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255"
                                            required>
                                    </div>
                                </div>
                                {{-- to ask --}}
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Brand Name">
                                            Brand Name<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="brand_name">
                                            <option value="">Select a value</option>
                                            <option value="W">W</option>
                                            <option value="Aurelia">Aurelia</option>
                                            <option value="Jaypore">Jaypore</option>
                                            <option value="Global Desi">Global Desi</option>
                                            <option value="FAB India">FAB India</option>
                                            <option value="Biba">Biba</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="NAME OF FIELD VISITOR">
                                            Name of Field Visitors<span class="text-danger"></span>
                                        </label>
                                        <select name="field_visitor" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="REGION">
                                            Region<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="region">
                                            <option value="">Select a value</option>
                                            <option value="Extension Of South Mumbai - Prabhadevi to Mahim">
                                                Extension Of South Mumbai - Prabhadevi to Mahim</option>
                                            <option value="Western Suburbs (A) - Bandra to Santacruz">
                                                Western Suburbs (A) - Bandra to Santacruz</option>
                                            <option value="Western Suburbs (B)- Ville Parle to Andheri">
                                                Western Suburbs (B)- Ville Parle to Andheri</option>
                                            <option value="Western Suburbs (C) - Jogeshwari to Goregoan">
                                                Western Suburbs (C) - Jogeshwari to Goregoan</option>
                                            <option value="Western Suburbs (D) - Malad to Borivali">
                                                Western Suburbs (D) - Malad to Borivali</option>
                                            <option value="North Mumbai - Beyond Borivali up to Virar">
                                                North Mumbai - Beyond Borivali up to Virar</option>
                                            <option value="Eastern Suburbs - Central Mumbai">
                                                Eastern Suburbs - Central Mumbai</option>
                                            <option value="Harbour Suburbs - Navi Mumbai">
                                                Harbour Suburbs - Navi Mumbai</option>
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
                                            <option value="Churchgate">Churchgate</option>
                                            <option value="Marine Lines">Marine Lines</option>
                                            <option value="Charni Roads">Charni Roads</option>
                                            <option value="Grant Roads">Grant Roads</option>
                                            <option value="Mumbai Central">Mumbai Central</option>
                                            <option value="Worli">Worli</option>
                                            <option value="Lower Parel">Lower Parel</option>
                                            <option value="Dadar">Dadar</option>
                                            <option value="Bandra">Bandra</option>
                                            <option value="Santacruz">Santacruz</option>
                                            <option value="Khar">Khar</option>
                                            <option value="Vile Parle">Vile Parle</option>
                                            <option value="Andheri">Andheri</option>
                                            <option value="Goregaon">Goregaon</option>
                                            <option value="Malad">Malad</option>
                                            <option value="kandivali">kandivali</option>
                                            <option value="Borivali">Borivali</option>
                                            <option value="Bhayander">Bhayander</option>
                                            <option value="Seawoods">Seawoods</option>
                                            <option value="Vashi">Vashi</option>
                                            <option value="Ghatkopar">Ghatkopar</option>
                                            <option value="Thane">Thane</option>
                                            <option value="Kalyan">Kalyan</option>
                                            <option value="Other">Other</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input textarea-margin">
                                        <label class="mt-" for="EXACT STORE ADDRESS">Exact Store Address</label>
                                        <textarea class="summernote" name="exact_address" id="summernote-16"></textarea>
                                    </div>
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

                            {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="PAGE SECTION">
                                            Page Section <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="page_section">
                                            <option value="">Select a value</option>
                                            <option value="AMBIENCE">Ambience</option>
                                            <option value="STAFF OBSERVATION">Staff Observation</option>
                                            <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                            <option value="PRODUCT OBSERVATION">Product Observation</option>
                                            <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                            <option value="BRANDING">Branding</option>
                                            <option value="TRIAL ROOMS">Trial Rooms</option>
                                        </select>
                                    </div>
                                </div> --}}

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="QA Attachment">Photos (Store From Outside, Racks, Window Display, Overall
                                        VM)
                                    </label>
                                    <div><small class="text-primary"></small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="QA_Attachments"></div>
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
                                    <label for="Overall Store Lighting">
                                        Overall Store Lighting <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_lighting">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Lighting On Products / Browser Lighting">
                                        Lighting On Products / Browser Lighting <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="lighting_products">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Overall Store Vibe">
                                        Overall Store Vibe <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_vibe">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Fragrance In Store">
                                        Fragrance In Store <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="fragrance_in_store">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Music Inside Store?">
                                        Music Inside Store? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="music_inside_store">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Space Utilization">
                                        Space Utilization <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="space_utilization">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Store Layout">
                                        Store Layout <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_layout">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="The Store Is Of How Many Floors?">
                                        The Store Is Of How Many Floors? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="floors">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="AC & Ventilation">
                                        AC & Ventilation <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="ac">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Mannequin Display">
                                        Mannequin Display <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="mannequin_display">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Seating Area (Inside Store)">
                                        Seating Area (Inside Store) <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="seating_area">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 ">
                                <div class="group-input">
                                    <label for="Product Visibility">
                                        Product Visibility <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="product_visiblity">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Store Signage And Graphics">
                                        Store Signage And Graphics <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="store_signage">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Does The Store Have Independent Washroom?">
                                        Does The Store Have Independent Washroom? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="independent_washroom">
                                        <option value="">Select a value</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input textarea-margin">
                                <label class="mt-4" for="Any Remarks">Any Remarks</label>
                                <p class="text-primary">Mention the flooring, curtains used, if any specific wallpaper /
                                    artistic objects are used to enhance the store vibe. Describe how the articles are kept
                                    on basis of the store (For eg., Left wall has kurtis in colour blocking, right wall has
                                    bottoms in another colour blocking, centre has accessories, end has trial rooms, cash
                                    counter has upselling items etc etc etc). </p>
                                <textarea class="summernote" name="any_remarks" id="summernote-16"></textarea>
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
                                    <label for="Page Section">
                                        Page Section <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section1">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE">Ambience</option>
                                        <option value="STAFF OBSERVATION">Staff Observation</option>
                                        <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                        <option value="PRODUCT OBSERVATION">Product Observation</option>
                                        <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                        <option value="BRANDING">Branding</option>
                                        <option value="TRIAL ROOMS">Trial Rooms</option>
                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Staff Behavior (Initial Staff Behaviour)">
                                Staff Behavior (Initial Staff Behaviour) <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="staff_behaviour">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Well Groomed">
                                Well Groomed <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="well_groomed">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Standard Staff Uniform">
                                Standard Staff Uniform <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="standard_staff_uniform">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    {{-- 23 --}}
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Trial Room Assistance">
                                Trial Room Assistance <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="trial_room_assistance">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="No. Of Customer At The Store Currently?">
                                No. Of Customer At The Store Currently? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="number_customer">
                                <option value="">Select a value</option>
                                <option value="0-2">0-2</option>
                                <option value="2-5">2-5</option>
                                <option value="5-7">5-7</option>
                                <option value="Above 7">Above 7</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Is The Staff Able To Handle The Customer?">
                                Is The Staff Able To Handle The Customer? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="handel_customer">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="No Customer Seen">No Customer Seen</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Knowledge Of Merchandise">
                                Knowledge Of Merchandise <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="knowledge_of_merchandise">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Awareness Of Brand / Offers / In General">
                                Awareness Of Brand / Offers / In General <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="awareness_of_brand">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Proactive">
                                Proactive <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="proactive">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Overall Customer Satisfaction (Staff Behavior Towards Customer/You)">
                                Overall Customer Satisfaction (Staff Behavior Towards Customer/You) <span
                                    class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="customer_satisfaction">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Billing Counter Experience">
                                Billing Counter Experience <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="billing_counter_experience">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="Any Remarks On Staff Observation?">Any Remarks On Staff
                            Observation?</label>
                        <p class="text-primary">Describe the staff uniform and anything that requires to be noted down
                            related to the store staff.</p>
                        <textarea class="summernote" name="remarks_on_staff_observation" id="summernote-16"></textarea>
                    </div>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                    </button>
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
                                    <label for="Page Section">
                                        Page Section <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_sacetion_2">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE">Ambience</option>
                                        <option value="STAFF OBSERVATION">Staff Observation</option>
                                        <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                        <option value="PRODUCT OBSERVATION">Product Observation</option>
                                        <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                        <option value="BRANDING">Branding</option>
                                        <option value="TRIAL ROOMS">Trial Rooms</option>
                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Is The Store Currently Running Any Offers Or Discounts?">
                                Is The Store Currently Running Any Offers Or Discounts? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="any_offers">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Current Offer In The Overall Store?">
                                Current Offer In The Overall Store? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="current_offer">
                                <option value="">Select a value</option>
                                <option value="Upto 20% - 30% Off">Upto 20% - 30% Off</option>
                                <option value="Upto 50% - 70% Off">Upto 50% - 70% Off</option>
                                <option value="Flat 20% - 30% Off">Flat 20% - 30% Off</option>
                                <option value="Flat 50% - 70% Off">Flat 50% - 70% Off</option>
                                <option value="Buy To Get">Buy To Get</option>
                                <option value="Other">Other</option>
                                <option value="None">None</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Return/ Exchange Policy">
                                Return/ Exchange Policy <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="exchange_policy">
                                <option value="">Select a value</option>
                                <option value="Only Exchange">Only Exchange</option>
                                <option value="Exchange Or Return">Exchange Or Return</option>
                                <option value="No Exchange No Return">No Exchange No Return</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Personal Occasion Discount Offered?">
                                Personal Occasion Discount Offered? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="discount_offer">
                                <option value="">Select a value</option>
                                <option value="Birthday Discount">Birthday Discount</option>
                                <option value="Anniversary Discount">Anniversary Discount</option>
                                <option value="Other Occasion">Other Occasion</option>
                                <option value="Premium Member Discount">Premium Member Discount</option>
                                <option value="None">None</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Reward Point Given?">
                                Reward Point Given? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="reward_point_given">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Use Of Influencer/ Brand Marketing">
                                Use Of Influencer/ Brand Marketing <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="use_of_influencer">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Age Group Of Customers Currently Seen At The Store">
                                Age Group Of Customers Currently Seen At The Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="age_group_of_customer">
                                <option value="">Select a value</option>
                                <option value="20-25">20-25</option>
                                <option value="25-35">25-35</option>
                                <option value="35-45">35-45</option>
                                <option value="Above 45">Above 45</option>
                                <option value="No Customers Seen">No Customers Seen</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Alteration Facility In Store">
                                Alteration Facility In Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="alteration_facility_in_store">
                                <option value="">Select a value</option>
                                <option value="Available">Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="Any Remarks Sale / Marketing Strategy?">Any Remarks Sale / Marketing
                            Strategy?</label>
                        <p class="text-primary">Mention the offers if any. Also mention reward points rule. Describe if you
                            feel anything is out of the box about marketing and sales strategy observed in this brand.
                            Mention exchange days/deadline.</p>
                        <textarea class="summernote" name="any_remarks_sale" id="summernote-16"></textarea>
                    </div>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                    </button>
                </div>
            </div>
        </div>


        <!-- -----------Tab-5------------ -->
        <div id="CCForm5" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Page Section">
                                        Page Section <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_3">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE">Ambience</option>
                                        <option value="STAFF OBSERVATION">Staff Observation</option>
                                        <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                        <option value="PRODUCT OBSERVATION">Product Observation</option>
                                        <option value="BRANDING">Branding</option>
                                        <option value="TRIAL ROOMS">Trial Rooms</option>
                                        <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Sub-Brands Offered?">
                                Sub-Brands Offered? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="sub_brand_offered">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Colour Palette Of The Entire Store At First Sight">
                                Colour Palette Of The Entire Store At First Sight <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="colour_palette">
                                <option value="">Select a value</option>
                                <option value="Light/Pastel">Light/Pastel</option>
                                <option value="Dark/Dull">Dark/Dull</option>
                                <option value="Mix Equally">Mix Equally</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Number Of Colourways Offered In Most Styles">
                                Number Of Colourways Offered In Most Styles <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="number_of_colourways">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Size Availability">
                                Size Availability <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="size_availiblity">
                                <option value="">Select a value</option>
                                <option value="XXS">XXS</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="2XL">2XL</option>
                                <option value="3XL">3XL</option>
                                <option value="4XL">4XL</option>
                                <option value="5XL">5XL</option>
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
                                <!-- Launch Deviation -->
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Details1-add">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">Row#</th>
                                        <th style="width: 16%">Category</th>
                                        <th style="width: 16%">Price</th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input disabled type="text" value="1"></td>
                                        <td><select type="text" name="details1[0][category]">
                                                <option value="">--Select Category--</option>
                                                <option value="Single Kurta">Single Kurta</option>
                                                <option value="Kurta Sets">Kurta Sets</option>
                                                <option value="Shirts / Tunics">Shirts / Tunics</option>
                                                <option value="Short Dresses">Short Dresses</option>
                                                <option value="Long Dresses">Long Dresses</option>
                                                <option value="Bottoms">Bottoms</option>
                                                <option value="Indo-Western Co-Ord Set">Indo-Western Co-Ord Set</option>
                                                <option value="Jumpsuit">Jumpsuit</option>
                                                <option value="Dupattas">Dupattas</option>
                                                <option value="Lehenga">Lehenga</option>
                                                <option value="Saree">Saree</option>
                                                <option value="Jackets & Shrugs">Jackets & Shrugs</option>
                                                <option value="Dress Material">Dress Material</option>
                                                <option value="Footwear">Footwear</option>
                                                <option value="Jewellery">Jewellery</option>
                                                <option value="Handbags">Handbags</option>
                                                <option value="Fragrances">Fragrances</option>
                                                <option value="Shawl/ Stole / Scarves">Shawl/ Stole / Scarves</option>
                                                <option value="Night Suits">Night Suits</option>
                                                <option value="Belts & Wallets">Belts & Wallets</option>
                                            </select></td>
                                        <td><select type="text" name="details1[0][price]">
                                                <option value="">--Select Price--</option>
                                                <option value="Below 500">Below 500</option>
                                                <option value="500-2000">500-2000</option>
                                                <option value="2100-5000">2100-5000</option>
                                                <option value="5100-7000">5100-7000</option>
                                                <option value="7100-9000">7100-9000</option>
                                                <option value="9100-15000">9100-15000</option>
                                                <option value="15100 & Above">15100 & Above</option>
                                                <option value="N/A">N/A</option>
                                            </select></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Did You Find Engaging Priced Merchandise At The Store Front?">
                                Did You Find Engaging Priced Merchandise At The Store Front?
                            </label>
                            <select id="select-state" placeholder="Select..." name="engaging_price">
                                <option value="">Select a value</option>
                                <option value="Lower Priced Items Were Displayed At The Store Front">Lower Priced Items
                                    Were Displayed At The Store Front</option>
                                <option value="Higher Priced Items Were Displayed At The Store Front">Higher Priced Items
                                    Were Displayed At The Store Front</option>
                                <option value="Mix Price Items Were Displayed At The Store Front">Mix Price Items Were
                                    Displayed At The Store Front</option>
                                <option value="Discount / Sale Items Were Displayed At The Store Front">Discount / Sale
                                    Items Were Displayed At The Store Front</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Merchandise Available In The Store">
                                Merchandise Available In The Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="merchadise_available">
                                <option value="">Select a value</option>
                                <option value="Apparel">Apparel</option>
                                <option value="Handbags">Handbags</option>
                                <option value="Footwear">Footwear</option>
                                <option value="Cosmetics & Skincare">Cosmetics & Skincare</option>
                                <option value="Home Decor">Home Decor</option>
                                <option value="Accessories">Accessories</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Details G-2
                            <button type="button" name="details2" id="Details2-add">+</button>
                            <span class="text-primary" data-bs-toggle="modal"
                                data-bs-target="#observation-field-instruction-modal"
                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                <!-- Launch Deviation -->
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
                                    <td><input disabled type="text" name="details2[0][row]" value="1"></td>
                                    <td><select type="text" name="details2[0][styles]">
                                            <option value="">--Select Category--</option>
                                            <option value="Casual Wear">Casual Wear</option>
                                            <option value="Traditional/Contemporary Wear">Traditional/Contemporary Wear
                                            </option>
                                            <option value="Ethnic Wear">Ethnic Wear</option>
                                            <option value="Western Wear">Western Wear</option>
                                            <option value="Indo-Western Wear">Indo-Western Wear</option>
                                            <option value="Designer/Occasion Wear">Designer/Occasion Wear</option>
                                        </select></td>
                                    <td><select type="text" name="details2[0][category]">
                                            <option value="">--Select Price--</option>
                                            <option value="Top/Tunics/Shirts">Top/Tunics/Shirts</option>
                                            <option value="Skirt/Lehenga">Skirt/Lehenga</option>
                                            <option value="Shirts / Tunics">Shirts / Tunics</option>
                                            <option value="Dresses/Gowns">Dresses/Gowns</option>
                                            <option value="Palazzo/Pants/Sharara/Leggings">Palazzo/Pants/Sharara/Leggings
                                            </option>
                                            <option value="Kurtis/Kurta">Kurtis/Kurta</option>
                                            <option value="Co-Ord Sets">Co-Ord Sets</option>
                                            <option value="Saree">Saree</option>
                                            <option value="Jumpsuit">Jumpsuit</option>
                                            <option value="Dupatta/Scarf/Shawl">Dupatta/Scarf/Shawl</option>
                                            <option value="Dress Material">Dress Material</option>
                                            <option value="Other">Other</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </td>
                                    <td><button type="text" class="removeRowBtn">Remove</button></td>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Types Of Fabric Available?">
                                Types Of Fabric Available? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="types_of_fabric">
                                <option value="">Select a value</option>
                                <option value="100% Cotton">100% Cotton</option>
                                <option value="100% Polyester">100% Polyester</option>
                                <option value="100% Viscose">100% Viscose</option>
                                <option value="Cotton Poly Blend">Cotton Poly Blend</option>
                                <option value="100% Linen">100% Linen</option>
                                <option value="Viscose Blend">Viscose Blend</option>
                                <option value="Silk">Silk</option>
                                <option value="Polyester Blend">Polyester Blend</option>
                                <option value="Chiffon / Georgette">Chiffon / Georgette</option>
                                <option value="Linen Blend">Linen Blend</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Prints Observed?">
                                Prints Observed? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="prints_observed">
                                <option value="">Select a value</option>
                                <option value="Small Floral Prints">Small Floral Prints</option>
                                <option value="Big Floral Prints">Big Floral Prints</option>
                                <option value="Geometric Prints">Geometric Prints</option>
                                <option value="Aztec Prints">Aztec Prints</option>
                                <option value="Traditional Prints (Paisley / Elephant Motifs Etc)">Traditional Prints
                                    (Paisley / Elephant Motifs Etc)</option>
                                <option value="Painting Prints">Painting Prints</option>
                                <option value="Animal Prints">Animal Prints</option>
                                <option value="Abstract Prints">Abstract Prints</option>
                                <option value="All Over Print">All Over Print</option>
                                <option value="Placement Print">Placement Print</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Embroideries Observed?">
                                Embroideries Observed? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="embroideries_observed">
                                <option value="">Select a value</option>
                                <option value="Thread Work">Thread Work</option>
                                <option value="Applique">Applique</option>
                                <option value="Bead WORK">Bead WORK</option>
                                <option value="Stone Work And Zardozi Embroidery">Stone Work And Zardozi Embroidery
                                </option>
                                <option value="Home Decor">Home Decor</option>
                                <option value="All Over Embroidery">All Over Embroidery</option>
                                <option value="Placement Embroidery">Placement Embroidery</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Overall Quality Of Garments In The Store">
                                Overall Quality Of Garments In The Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="quality_of_garments">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="Any Remarks On Product Observation?">Any Remarks On Product
                            Observation?</label>
                        <p class="text-primary">Mention any sub brands if offered, and anything worth to be noted in this
                            section.</p>
                        <textarea class="summernote" name="remarks_on_product_observation" id="summernote-16"></textarea>
                    </div>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                    </button>
                </div>
            </div>
        </div>




        <div id="CCForm6" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Page Section">
                                        Page Section <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_4">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE">Ambience</option>
                                        <option value="STAFF OBSERVATION">Staff Observation</option>
                                        <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                        <option value="PRODUCT OBSERVATION">Product Observation</option>
                                        <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                        <option value="BRANDING">Branding</option>
                                        <option value="TRIAL ROOMS">Trial Rooms</option>
                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="The Entrance Of The Store (Display Of Garments)">
                                The Entrance Of The Store (Display Of Garments) <span class="text-danger"></span>
                            </label>
                            <p class="text-primary">Here, mention how you feel about the store from outside at the first
                                glance. Keep in mind if the store visually invites you in or not through colour blocking or
                                mannequin display or anything else.</p>
                            <select id="select-state" placeholder="Select..." name="entrance_of_the_store">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Story Telling">
                                Story Telling <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="story_telling">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Stock Display In The Entire Store">
                                Stock Display In The Entire Store <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="stock_display">
                                <option value="">Select a value</option>
                                <option value="Limited Sizes Are Displayed On Racks">Limited Sizes Are Displayed On Racks
                                </option>
                                <option value="All Sizes Are Displayed Together On The Same Rack">All Sizes Are Displayed
                                    Together On The Same Rack</option>
                                <option value="All Sizes Are Displayed But On Different Racks">All Sizes Are Displayed But
                                    On Different Racks</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Spacing Of Clothes On The Rack">
                                Spacing Of Clothes On The Rack <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="spacing_of_clothes">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="How Many No. Of Customers Can Browse At One Time In One Section?">
                                How Many No. Of Customers Can Browse At One Time In One Section? <span
                                    class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="how_many_no_of_customers">
                                <option value="">Select a value</option>
                                <option value="0-2">0-2</option>
                                <option value="3-4">3-4</option>
                                <option value="3">3</option>
                                <option value="More Than 4">More Than 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="Any Remarks On VM / Space Management">Any Remarks On VM / Space
                            Management</label>
                        <p class="text-primary">Mention the colours/prints/styles displayed at the entrance of the store,
                            describe the alignment of the store (what's kept on the left side of the store, what's on the
                            right side etc). Also mention if you feel the store is well spaced or not, meaning if the space
                            is properly utilized or over utilized or under utilized. Describe anything else that's relevant
                            to this section.</p>
                        <textarea class="summernote" name="any_remarks_on_vm" id="summernote-16"></textarea>
                    </div>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                    </button>
                </div>
            </div>
        </div>

        <div id="CCForm7" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Page Section">
                                        Page Section <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_5">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE">Ambience</option>
                                        <option value="STAFF OBSERVATION">Staff Observation</option>
                                        <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                        <option value="PRODUCT OBSERVATION">Product Observation</option>
                                        <option value="BRANDING">Branding</option>
                                        <option value="TRIAL ROOMS">Trial Rooms</option>
                                        <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Suitable Brand Tagline">
                                Suitable Brand Tagline <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="brand_tagline">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Type Of Bill">
                                Type Of Bill <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="type_of_ball">
                                <option value="">Select a value</option>
                                <option value="Digital Only">Digital Only</option>
                                <option value="Paper Printed Bill">Paper Printed Bill</option>
                                <option value="Digital And Paper Printed Both">Digital And Paper Printed Both</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input textarea-margin">
                        <label class="mt-4" for="Any Remarks On Branding?">Any Remarks On Branding?</label>
                        <p class="text-primary">If you see a tagline then mention it here. Add anything else that you feel
                            is worthy to be noted about branding here.</p>
                        <textarea class="summernote" name="any_ramrks_on_the_branding" id="summernote-16"></textarea>
                    </div>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                    </button>
                </div>
            </div>
        </div>




        <div id="CCForm8" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Page Section">
                                        Page Section <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="page_section_6">
                                        <option value="">Select a value</option>
                                        <option value="AMBIENCE">Ambience</option>
                                        <option value="STAFF OBSERVATION">Staff Observation</option>
                                        <option value="SALE / MARKETING STRATEGY">Sale / Marketing Strategy</option>
                                        <option value="PRODUCT OBSERVATION">Product Observation</option>
                                        <option value="BRANDING">Branding</option>
                                        <option value="TRIAL ROOMS">Trial Rooms</option>
                                        <option value="VM & SPACE MANAGEMENT">VM & Space Management</option>
                                    </select>
                                </div>
                            </div> --}}

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Number Of Trial Rooms?">
                                Number Of Trial Rooms? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="number_of_trial_rooms_">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="More Than 4">More Than 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Hygiene">
                                Hygiene <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="hygiene_">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Ventilation">
                                Ventilation <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="ventilation_">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Queue Outside The Trial Room">
                                Queue Outside The Trial Room <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="queue_outside_the_trial_room">
                                <option value="">Select a value</option>
                                <option value="No Queue">No Queue</option>
                                <option value="Less Than 2">Less Than 2</option>
                                <option value="2-5 People">2-5 People</option>
                                <option value="5 And Above">5 And Above</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Mirror Size">
                                Mirror Size <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="mirror_size">
                                <option value="">Select a value</option>
                                <option value="Full Length - 4 Sides">Full Length - 4 Sides</option>
                                <option value="Full Length - 3 Sides">Full Length - 3 Sides</option>
                                <option value="Full Length -2 Sides">Full Length -2 Sides</option>
                                <option value="Full Length - 1 Side">Full Length - 1 Side</option>
                                <option value="Half Mirror">Half Mirror</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Trial Room Lighting">
                                Trial Room Lighting <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="trial_room_lighting">
                                <option value="">Select a value</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Is Seating Inside The Trial Room Available?">
                                Is Seating Inside The Trial Room Available? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="trial_room_available">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Seating Around Trial Room Area (For Companions)">
                                Seating Around Trial Room Area (For Companions) <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="seating_around_trial_room">
                                <option value="">Select a value</option>
                                <option value="Not Available">Not Available</option>
                                <option value="1 Seater">1 Seater</option>
                                <option value="2 Seater Couch">2 Seater Couch</option>
                                <option value="3 Seater Couch">3 Seater Couch</option>
                                <option value="Multiple Seater Couch">Multiple Seater Couch</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Cloth Hanger Inside The Trial Room Available?">
                                Cloth Hanger Inside The Trial Room Available? <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="cloth_hanger">
                                <option value="">Select a value</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="group-input">
                        <label class="mt-4" for="Any Remarks On The Trial Room?">Any Remarks On The Trial
                            Room?</label>
                        <p class="text-primary">Mention the cleanliness and space in the trial room. Also if the trial
                            room has any specific decor like planters or wall displays or anything else.</p>
                        <textarea class="summernote" name="any_remarks_on_the_trial_room" id="summernote-16"></textarea>
                    </div>
                </div>

                <div class="group-input textarea-margin">
                    <label class="mt-4" for="Any Remarks / Comments Add On The Overall Store?">Any Remarks / Comments
                        Add On The Overall Store?</label>
                    <textarea class="summernote" name="comments_on_the_overall_store" id="summernote-16"></textarea>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                    </button>
                </div>
            </div>
        </div>

        {{-- </div> --}}
        {{-- </div> --}}

        <div id="CCForm9" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Survey By</label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Cancel BY">Survey On</label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        {{-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> --}}

                        <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                            </a> </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>

    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
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
            var index = 1;

            $('#Details1-add').click(function(e) {


                e.preventDefault();


                function generateTableRow(serialNumber, index) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><select type="text" name="details1[' + serialNumber + '][' + index +
                        '][category]">' +
                        '<option value="">--Select Category--</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Single Kurta]">Single Kurta</option>' +


                        '<option value="details1[0][category][' + index +
                        '][Kurta Sets]">Kurta Sets</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Shirts / Tunics]">Shirts / Tunics</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Short Dresses]">Short Dresses</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Long Dresses]">Long Dresses</option>' +
                        '<option value="details1[0][category][' + index + '][Bottoms]">Bottoms</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Indo-Western Co-Ord Set]">Indo-Western Co-Ord Set</option>' +
                        '<option value="details1[0][category][' + index + '][Jumpsuit]">Jumpsuit</option>' +
                        '<option value="details1[0][category][' + index + '][Dupattas]">Dupattas</option>' +
                        '<option value="details1[0][category][' + index + '][Lehenga]">Lehenga</option>' +
                        '<option value="details1[0][category][' + index + '][Saree]">Saree</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Jackets & Shrugs]">Jackets & Shrugs</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Dress Material]">Dress Material</option>' +
                        '<option value="details1[0][category][' + index + '][Footwear]">Footwear</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Jewellery]">Jewellery</option>' +
                        '<option value="details1[0][category][' + index + '][Handbags]">Handbags</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Fragrances]">Fragrances</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Shawl/ Stole / Scarves]">Shawl/ Stole / Scarves</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Night Suits]">Night Suits</option>' +
                        '<option value="details1[0][category][' + index +
                        '][Belts & Wallets]">Belts & Wallets</option>' +
                        '</select></td>' +
                        '<td><select type="text" name="details1[' + serialNumber + '][price]">' +
                        '<option value="">--Select Price--</option>' +
                        '<option value="details1[0][price][' + index + '][Below 500]">Below 500</option>' +
                        '<option value="details1[0][price][' + index + '][500-2000]">500-2000</option>' +
                        '<option value="details1[0][price][' + index + '][2100-5000]">2100-5000</option>' +
                        '<option value="details1[0][price][' + index + '][5100-7000]">5100-7000</option>' +
                        '<option value="details1[0][price][' + index + '][7100-9000]">7100-9000</option>' +
                        '<option value="details1[0][price][' + index +
                        '][9100-15000]">9100-15000</option>' +
                        '<option value="details1[0][price][' + index +
                        '][15100 & Above]">15100 & Above</option>' +
                        '<option value="details1[0][price][' + index + '][N/A]">N/A</option>' +
                        '</select></td>' +
                        '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Details1-add tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1, index);
                tableBody.append(newRow);
                index++;
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
                        '<option value="Designer/Occasion Wear">Designer/Occasion Wear</option>' +
                        '</select></td>' +
                        '<td><select type="text" name="details2[' + serialNumber + '][price]">' +
                        '<option value="">--Select Price--</option>' +
                        '<option value="Top/Tunics/Shirts">Top/Tunics/Shirts</option>' +
                        '<option value="Skirt/Lehenga">Skirt/Lehenga</option>' +
                        '<option value="Shirts / Tunics">Shirts / Tunics</option>' +
                        '<option value="Dresses/Gowns">Dresses/Gowns</option>' +
                        '<option value="Palazzo/Pants/Sharara/Leggings">Palazzo/Pants/Sharara/Leggings</option>' +
                        '<option value="Kurtis/Kurta">Kurtis/Kurta</option>' +
                        '<option value="Co-Ord Sets">Co-Ord Sets</option>' +
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
