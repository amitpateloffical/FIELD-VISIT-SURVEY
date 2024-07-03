@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        .textarea-margin{
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

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Date of Initiation</label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date">Date</label>
                                        <input type="text" value="{{ date('d-M-Y') }}" name="date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="date">
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Time">Time</label>
                                        <input type="time" value="" name="time">
                                        {{-- <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date"> --}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Brand Name">
                                            Brand Name<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="brand_name">
                                            <option value="">Select a value</option>
                                            <option value="W">W</option>
                                            <option value="AURELIA">AURELIA</option>
                                            <option value="JAYPORE">JAYPORE</option>
                                            <option value="GLOBAL DESI">GLOBAL DESI</option>
                                            <option value="FAB INDIA">FAB INDIA</option>
                                            <option value="BIBA">BIBA</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="NAME OF FIELD VISITOR">
                                            Name of Field Visitors<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="field_visitor">
                                            <option value="">Select a value</option>
                                            <option value="Chaitanya">Chaitanya</option>
                                            <option value="Rekha">Rekha</option>
                                            <option value="Sachin">Sachin</option>
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
                                            <option value="EXTENSION OF SOUTH MUMBAI - PRABHADEVI TO MAHIM">EXTENSION OF
                                                SOUTH MUMBAI - PRABHADEVI TO MAHIM</option>
                                            <option value="WESTERN SUBURBS (A) - BANDRA TO SANTACRUZ">WESTERN SUBURBS (A) -
                                                BANDRA TO SANTACRUZ</option>
                                            <option value="WESTERN SUBURBS (B)- VILLE PARLE TO ANDHERI">WESTERN SUBURBS
                                                (B)- VILLE PARLE TO ANDHERI</option>
                                            <option value="WESTERN SUBURBS (C) - JOGESHWARI TO GOREGOAN">WESTERN SUBURBS
                                                (C) - JOGESHWARI TO GOREGOAN</option>
                                            <option value="WESTERN SUBURBS (D) - MALAD TO BORIVALI">WESTERN SUBURBS (D) -
                                                MALAD TO BORIVALI</option>
                                            <option value="NORTH MUMBAI - BEYOND BORIVALI UP TO VIRAR">NORTH MUMBAI -
                                                BEYOND BORIVALI UP TO VIRAR</option>
                                            <option value="EASTERN SUBURBS - CENTRAL MUMBAI">EASTERN SUBURBS - CENTRAL
                                                MUMBAI</option>
                                            <option value="HARBOUR SUBURBS - NAVI MUMBAI">HARBOUR SUBURBS - NAVI MUMBAI
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
                                        <textarea  class="summernote" name="exact_address" id="summernote-16"></textarea>
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
                                        <label for="QA Attachment">Photos (Store From Outside, Racks, Window Display, Overall VM)
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
                    
                                <div  class="group-input textarea-margin">
                                    <label class="mt-4" for="Any Remarks">Any Remarks</label>
                                    <p class="text-primary">Mention the flooring, curtains used, if any specific wallpaper / artistic objects are used to enhance the store vibe. Describe how the articles are kept on basis of the store (For eg., Left wall has kurtis in colour blocking, right wall has bottoms in another colour blocking, centre has accessories, end has trial rooms, cash counter has upselling items etc etc etc). </p>
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
                
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Trial Room Assistance">
                                        Trial Room Assistance <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="trial_room_assistance">
                                        <option value="">Select a value</option>
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
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
                                        <option value="ABOVE 7">Above 7</option>
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
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                        <option value="NO CUSTOMER SEEN">No Customer Seen</option>
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
                                        Overall Customer Satisfaction (Staff Behavior Towards Customer/You) <span class="text-danger"></span>
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
                                <label class="mt-4" for="Any Remarks On Staff Observation?">Any Remarks On Staff Observation?</label>
                                <p class="text-primary">Describe the staff uniform and anything that requires to be noted down related to the store staff.</p>
                                <textarea class="summernote" name="remarks_on_staff_observation" id="summernote-16"></textarea>
                            </div>
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
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
                                        <option value="UPTO 20% - 30% OFF">Upto 20% - 30% Off</option>
                                        <option value="UPTO 50% - 70% OFF">Upto 50% - 70% Off</option>
                                        <option value="FLAT 20% - 30% OFF">Flat 20% - 30% Off</option>
                                        <option value="FLAT 50% - 70% OFF">Flat 50% - 70% Off</option>
                                        <option value="BUY TO GET">Buy To Get</option>
                                        <option value="OTHER">Other</option>
                                        <option value="NONE">None</option>
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
                                        <option value="ONLY EXCHANGE">Only Exchange</option>
                                        <option value="EXCHANGE OR RETURN">Exchange Or Return</option>
                                        <option value="NO EXCHANGE NO RETURN">No Exchange No Return</option>
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
                                        <option value="BIRTHDAY DISCOUNT">Birthday Discount</option>
                                        <option value="ANNIVERSARY DISCOUNT">Anniversary Discount</option>
                                        <option value="OTHER OCCASION">Other Occasion</option>
                                        <option value="PREMIUM MEMBER DISCOUNT">Premium Member Discount</option>
                                        <option value="NONE">None</option>
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
                                        <option value="NO CUSTOMERS SEEN">No Customers Seen</option>
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
                                        <option value="AVAILABLE">Available</option>
                                        <option value="NOT AVAILABLE">Not Available</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="group-input textarea-margin">
                                <label class="mt-4" for="Any Remarks Sale / Marketing Strategy?">Any Remarks Sale / Marketing Strategy?</label>
                                <p class="text-primary">Mention the offers if any. Also mention reward points rule. Describe if you feel anything is out of the box about marketing and sales strategy observed in this brand. Mention exchange days/deadline.</p>
                                <textarea class="summernote" name="any_remarks_sale" id="summernote-16"></textarea>
                            </div>
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
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
                                        <option value="LIGHT/PASTEL">Light/Pastel</option>
                                        <option value="DARK/DULL">Dark/Dull</option>
                                        <option value="MIX EQUALLY">Mix Equally</option>
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
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        <!-- Launch Deviation -->
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
                                            <td><input disabled type="text" name="details1[0][row]" value="1"></td>
                                            <td><select type="text" name="details1[0][category]">
                                                <option value="">--Select Category--</option>
                                                <option value="SINGLE KURTA">Single Kurta</option>
                                                <option value="KURTA SETS">Kurta Sets</option>
                                                <option value="SHIRTS / TUNICS">Shirts / Tunics</option>
                                                <option value="SHORT DRESSES">Short Dresses</option>
                                                <option value="LONG DRESSES">Long Dresses</option>
                                                <option value="BOTTOMS">Bottoms</option>
                                                <option value="INDO-WESTERN CO-ORD SET">Indo-Western Co-Ord Set</option>
                                                <option value="JUMPSUIT">Jumpsuit</option>
                                                <option value="DUPATTAS">Dupattas</option>
                                                <option value="LEHENGA">Lehenga</option>
                                                <option value="SAREE">Saree</option>
                                                <option value="JACKETS & SHRUGS">Jackets & Shrugs</option>
                                                <option value="DRESS MATERIAL">Dress Material</option>
                                                <option value="FOOTWEAR">Footwear</option>
                                                <option value="JEWELLRY">Jewellry</option>
                                                <option value="HANDBAGS">Handbags</option>
                                                <option value="FRAGRANCES">Fragrances</option>
                                                <option value="SHAWL/ STOLE / SCARVES">Shawl/ Stole / Scarves</option>
                                                <option value="NIGHT SUITS">Night Suits</option>
                                                <option value="BELTS & WALLETS">Belts & Wallets</option>
                                            </select></td>
                                            <td><select type="text" name="details1[0][price]">
                                                    <option value="">--Select Price--</option>
                                                    <option value="BELOW 500">Below 500</option>
                                                    <option value="500-2000">500-2000</option>
                                                    <option value="2100-5000">2100-5000</option>
                                                    <option value="5100-7000">5100-7000</option>
                                                    <option value="7100-9000">7100-9000</option>
                                                    <option value="9100-15000">9100-15000</option>
                                                    <option value="15100 & ABOVE">15100 & Above</option>
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
                                    <label for="Did You Find Engaging Priced Merchandise At The Store Front?">
                                        Did You Find Engaging Priced Merchandise At The Store Front?
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="engaging_price">
                                        <option value="">Select a value</option>
                                        <option value="LOWER PRICED ITEMS WERE DISPLAYED AT THE STORE FRONT">Lower Priced Items Were Displayed At The Store Front</option>
                                        <option value="HIGHER PRICED ITEMS WERE DISPLAYED AT THE STORE FRONT">Higher Priced Items Were Displayed At The Store Front</option>
                                        <option value="MIX PRICE ITEMS WERE DISPLAYED AT THE STORE FRONT">Mix Price Items Were Displayed At The Store Front</option>
                                        <option value="DISCOUNT / SALE ITEMS WERE DISPLAYED AT THE STORE FRONT">Discount / Sale Items Were Displayed At The Store Front</option>
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
                                        <option value="APPAREL">Apparel</option>
                                        <option value="HANDBAGS">Handbags</option>
                                        <option value="FOOTWEAR">Footwear</option>
                                        <option value="COSMETICS & SKINCARE">Cosmetics & Skincare</option>
                                        <option value="HOME DECOR">Home Decor</option>
                                        <option value="ACCESSORIES">Accessories</option>
                                        <option value="OTHERS">Others</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Details G-2
                                    <button type="button" name="details2" id="Details2-add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
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
                                                <option value="CASUAL WEAR">Casual Wear</option>
                                                <option value="TRADITIONAL/CONTEMPORARY WEAR">Traditional/Contemporary Wear</option>
                                                <option value="ETHNIC WEAR">Ethnic Wear</option>
                                                <option value="WESTERN WEAR">Western Wear</option>
                                                <option value="INDO-WESTERN WEAR">Indo-Western Wear</option>
                                                <option value="DESIGNER/OCCASION WEAR">Designer/Occasion Wear</option>
                                            </select></td>
                                            <td><select type="text" name="details2[0][category]">
                                                    <option value="">--Select Price--</option>
                                                    <option value="TOP/TUNICS/SHIRTS">Top/Tunics/Shirts</option>
                                                    <option value="SKIRT/LEHENGA">Skirt/Lehenga</option>
                                                    <option value="SHIRTS / TUNICS">Shirts / Tunics</option>
                                                    <option value="DRESSES/GOWNS">Dresses/Gowns</option>
                                                    <option value="PALAZZO/PANTS/SHARARA/LEGGINGS">Palazzo/Pants/Sharara/Leggings</option>
                                                    <option value="KURTIS/KURTA">Kurtis/Kurta</option>
                                                    <option value="CO-ORD SETS">Co-Ord Sets</option>
                                                    <option value="SAREE">Saree</option>
                                                    <option value="JUMPSUIT">Jumpsuit</option>
                                                    <option value="DUPATTA/SCARF/SHAWL">Dupatta/Scarf/Shawl</option>
                                                    <option value="DRESS MATERIAL">Dress Material</option>
                                                    <option value="OTHER">Other</option>
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
                                        <option value="100% COTTON">100% Cotton</option>
                                        <option value="100% POLYESTER">100% Polyester</option>
                                        <option value="100% VISCOSE">100% Viscose</option>
                                        <option value="COTTON POLY BLEND">Cotton Poly Blend</option>
                                        <option value="100% LINEN">100% Linen</option>
                                        <option value="VISCOSE BLEND">Viscose Blend</option>
                                        <option value="SILK">Silk</option>
                                        <option value="POLYESTER BLEND">Polyester Blend</option>
                                        <option value="CHIFFON / GEORGETTE">Chiffon / Georgette</option>
                                        <option value="LINEN BLEND">Linen Blend</option>
                                        <option value="OTHERS">Others</option>
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
                                        <option value="SMALL FLORAL PRINTS">Small Floral Prints</option>
                                        <option value="BIG FLORAL PRINTS">Big Floral Prints</option>
                                        <option value="GEOMETRIC PRINTS">Geometric Prints</option>
                                        <option value="AZTEC PRINTS">Aztec Prints</option>
                                        <option value="TRADITIONAL PRINTS (PAISLEY / ELEPHANT MOTIFS ETC)">Traditional Prints (Paisley / Elephant Motifs Etc)</option>
                                        <option value="PAINTING PRINTS">Painting Prints</option>
                                        <option value="ANIMAL PRINTS">Animal Prints</option>
                                        <option value="ABSTRACT PRINTS">Abstract Prints</option>
                                        <option value="ALL OVER PRINT">All Over Print</option>
                                        <option value="PLACEMENT PRINT">Placement Print</option>
                                        <option value="OTHERS">Others</option>
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
                                        <option value="THREAD WORK">Thread Work</option>
                                        <option value="APPLIQUE">Applique</option>
                                        <option value="BEAD WORK">Bead Work</option>
                                        <option value="STONE WORK AND ZARDOZI EMBROIDERY">Stone Work And Zardozi Embroidery</option>
                                        <option value="HOME DECOR">Home Decor</option>
                                        <option value="ALL OVER EMBROIDERY">All Over Embroidery</option>
                                        <option value="PLACEMENT EMBROIDERY">Placement Embroidery</option>
                                        <option value="OTHERS">Others</option>
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
                                <label class="mt-4" for="Any Remarks On Product Observation?">Any Remarks On Product Observation?</label>
                                <p class="text-primary">Mention any sub brands if offered, and anything worth to be noted in this section.</p>
                                <textarea class="summernote" name="remarks_on_product_observation" id="summernote-16"></textarea>
                            </div>
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
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
                                    <p class="text-primary">Here, mention how you feel about the store from outside at the first glance. Keep in mind if the store visually invites you in or not through colour blocking or mannequin display or anything else.</p>
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
                                        <option value="LIMITED SIZES ARE DISPLAYED ON RACKS">Limited Sizes Are Displayed On Racks</option>
                                        <option value="ALL SIZES ARE DISPLAYED TOGETHER ON THE SAME RACK">All Sizes Are Displayed Together On The Same Rack</option>
                                        <option value="ALL SIZES ARE DISPLAYED BUT ON DIFFERENT RACKS">All Sizes Are Displayed But On Different Racks</option>
                                        <option value="OTHERS">Others</option>
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
                                        How Many No. Of Customers Can Browse At One Time In One Section? <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="how_many_no_of_customers">
                                        <option value="">Select a value</option>
                                        <option value="0-2">0-2</option>
                                        <option value="3-4">3-4</option>
                                        <option value="3">3</option>
                                        <option value="MORE THAN 4">More Than 4</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="group-input textarea-margin">
                                <label class="mt-4" for="Any Remarks On VM / Space Management">Any Remarks On VM / Space Management</label>
                                <p class="text-primary">Mention the colours/prints/styles displayed at the entrance of the store, describe the alignment of the store (what's kept on the left side of the store, what's on the right side etc). Also mention if you feel the store is well spaced or not, meaning if the space is properly utilized or over utilized or under utilized. Describe anything else that's relevant to this section.</p>
                                <textarea class="summernote" name="any_remarks_on_vm" id="summernote-16"></textarea>
                            </div>
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
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
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
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
                                        <option value="DIGITAL ONLY">Digital Only</option>
                                        <option value="PAPER PRINTED BILL">Paper Printed Bill</option>
                                        <option value="DIGITAL AND PAPER PRINTED BOTH">Digital And Paper Printed Both</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="group-input textarea-margin">
                                <label class="mt-4" for="Any Remarks On Branding?">Any Remarks On Branding?</label>
                                <p class="text-primary">If you see a tagline then mention it here. Add anything else that you feel is worthy to be noted about branding here.</p>
                                <textarea class="summernote" name="any_ramrks_on_the_branding" id="summernote-16"></textarea>
                            </div>
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
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
                                        <option value="MORE THAN 4">More Than 4</option>
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
                                        <option value="NO QUEUE">No Queue</option>
                                        <option value="LESS THAN 2">Less Than 2</option>
                                        <option value="2-5 PEOPLE">2-5 People</option>
                                        <option value="5 AND ABOVE">5 And Above</option>
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
                                        <option value="FULL LENGTH - 4 SIDES">Full Length - 4 Sides</option>
                                        <option value="FULL LENGTH - 3 SIDES">Full Length - 3 Sides</option>
                                        <option value="FULL LENGTH -2 SIDES">Full Length -2 Sides</option>
                                        <option value="FULL LENGTH - 1 SIDE">Full Length - 1 Side</option>
                                        <option value="HALF MIRROR">Half Mirror</option>
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
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
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
                                        <option value="NOT AVAILABLE">Not Available</option>
                                        <option value="1 SEATER">1 Seater</option>
                                        <option value="2 SEATER COUCH">2 Seater Couch</option>
                                        <option value="3 SEATER COUCH">3 Seater Couch</option>
                                        <option value="MULTIPLE SEATER COUCH">Multiple Seater Couch</option>
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
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="group-input">
                                <label class="mt-4" for="Any Remarks On The Trial Room?">Any Remarks On The Trial Room?</label>
                                <p class="text-primary">Mention the cleanliness and space in the trial room. Also if the trial room has any specific decor like planters or wall displays or anything else.</p>
                                <textarea class="summernote" name="any_remarks_on_the_trial_room" id="summernote-16"></textarea>
                            </div>
                        </div>
                
                        <div class="group-input textarea-margin">
                            <label class="mt-4" for="Any Remarks / Comments Add On The Overall Store?">Any Remarks / Comments Add On The Overall Store?</label>
                            <textarea class="summernote" name="comments_on_the_overall_store" id="summernote-16"></textarea>
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
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

                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit
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
            $('#Details1-add').click(function(e) {

                e.preventDefault();

                function generateTableRow(serialNumber) {
                    var html = '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '   <td><select type="text" name="details1[' + serialNumber + '][category]">'+
                                            '<option value="">--Select Category--</option>'+
                                            '<option value="SINGLE KURTA">SINGLE KURTA</option>'+
                                            '<option value="KURTA SETS">KURTA SETS</option>'+
                                            '<option value="SHIRTS / TUNICS">SHIRTS / TUNICS</option>'+
                                            '<option value="SHORT DRESSES">SHORT DRESSES</option>'+
                                            '<option value="LONG DRESSES">LONG DRESSES</option>'+
                                            '<option value="BOTTOMS">BOTTOMS</option>'+
                                            '<option value="INDO-WESTERN CO-ORD SET">INDO-WESTERN CO-ORD SET</option>'+
                                            '<option value="JUMPSUIT">JUMPSUIT</option>'+
                                            '<option value="DUPATTAS">DUPATTAS</option>'+
                                            '<option value="LEHENGA">LEHENGA</option>'+
                                            '<option value="SAREE">SAREE</option>'+
                                            '<option value="JACKETS & SHRUGS">JACKETS & SHRUGS</option>'+
                                            '<option value="DRESS MATERIAL">DRESS MATERIAL</option>'+
                                            '<option value="FOOTWEAR">FOOTWEAR</option>'+
                                            '<option value="JEWELLRY">JEWELLRY</option>'+
                                            '<option value="HANDBAGS">HANDBAGS</option>'+
                                            '<option value="FRAGRANCES">FRAGRANCES</option>'+
                                            '<option value="SHAWL/ STOLE / SCARVES">SHAWL/ STOLE / SCARVES</option>'+
                                            '<option value="NIGHT SUITS">NIGHT SUITS</option>'+
                                            '<option value="BELTS & WALLETS">BELTS & WALLETS</option>'+
                                            '</select></td>' +
                                            '<td><select type="text" name="details1[' + serialNumber + '][price]">'+
                                                    '<option value="">--Select Price--</option>'+
                                                    '<option value="BELOW 500">BELOW 500</option>'+
                                                    '<option value="500-2000">500-2000</option>'+
                                                    '<option value="2100-5000">2100-5000</option>'+
                                                    '<option value="5100-7000">5100-7000</option>'+
                                                    '<option value="7100-9000">7100-9000</option>'+
                                                    '<option value="9100-15000">9100-15000</option>'+
                                                    '<option value="15100 & ABOVE">15100 & ABOVE</option>'+
                                                    '<option value="N/A">N/A</option>'+
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
                    '   <td><select type="text" name="details2[' + serialNumber + '][category]">'+
                                        '<option value="">--Select Category--</option>'+
                                        '<option value="CASUAL WEAR">CASUAL WEAR</option>'+
                                        '<option value="TRADITIONAL/CONTEMPORARY WEAR">TRADITIONAL/CONTEMPORARY WEAR</option>'+
                                        '<option value="ETHNIC WEAR">ETHNIC WEAR</option>'+
                                        '<option value="WESTERN WEAR">WESTERN WEAR</option>'+
                                        '<option value="INDO-WESTERN WEAR">INDO-WESTERN WEAR</option>'+
                                        '<option value="BOTTOMS">BOTTOMS</option>'+
                                        '<option value="INDO-WESTERN CO-ORD SET">INDO-WESTERN CO-ORD SET</option>'+
                                        '<option value="DESIGNER/OCCASION WEAR">DESIGNER/OCCASION WEAR</option>'+
                                        '</select></td>' +
                                        '<td><select type="text" name="details2[' + serialNumber + '][price]">'+
                                                '<option value="">--Select Price--</option>'+
                                                '<option value="TOP/TUNICS/SHIRTS">TOP/TUNICS/SHIRTS</option>'+
                                                '<option value="SKIRT/LEHENGA">SKIRT/LEHENGA</option>'+
                                                '<option value="SHIRTS / TUNICS">SHIRTS / TUNICS</option>'+
                                                '<option value="DRESSES/GOWNS">DRESSES/GOWNS</option>'+
                                                '<option value="PALAZZO/PANTS/SHARARA/LEGGINGS">PALAZZO/PANTS/SHARARA/LEGGINGS</option>'+
                                                '<option value="KURTIS/KURTA">KURTIS/KURTA</option>'+
                                                '<option value="CO-ORD SETS">CO-ORD SETS</option>'+
                                                '<option value="SAREE">SAREE</option>'+
                                                '<option value="JUMPSUIT">JUMPSUIT</option>'+
                                                '<option value="DUPATTA/SCARF/SHAWL">DUPATTA/SCARF/SHAWL</option>'+
                                                '<option value="DRESS MATERIAL">DRESS MATERIAL</option>'+
                                                '<option value="OTHER">OTHER</option>'+
                                                '<option value="N/A">N/A</option>'+

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
