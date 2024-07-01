<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vidyagxp - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }

    .Summer {
        font-weight: bold;
        font-size:14px;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Field Visit Survey Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://vidyagxp.com/vidyaGxp_logo.png" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>FVS No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS(session()->get('division')) }}/FVS/{{ Helpers::year($data->created_at) }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table>
            <tr>
                <td class="w-40">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-60">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>

                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">
                            @if ($data->id)
                                {{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if (Helpers::getDivisionName(session()->get('division')))
                                {{ Helpers::getDivisionName(session()->get('division')) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Auth::user()->name }}</td>

                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date</th>
                        <td class="w-30">
                            @if ($data->date)
                                {{ $data->date }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Time</th>
                        <td class="w-30">
                            @if ($data->time)
                                {{ $data->time }}
                            @else
                                Not Applicable
                            @endif
                        </td>


                    </tr>
                    <tr>
                        <th class="w-20">Brand Name</th>
                        <td class="w-30">{{ $data->brand_name }}</td>

                        <th class="w-20">Name of field visitor</th>
                        <td class="w-30">{{ $data->field_visitor }}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Region</th>
                        <td class="w-30">
                            @if ($data->region)
                                {{ $data->region }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Exact Location</th>
                        <td class="w-30">{{ $data->reference_document }}</td>


                    </tr>
                </table>

                <label class="Summer" for="">Exact Store Address</label>
                <div>
                    @if ($data->exact_address)
                    {!! $data->exact_address !!}
                    @else
                    Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Photos (Store From Outside, Racks, Window Display, Overall VM)</th>
                        <td class="w-30">
                            @if ($data->photos)
                                {{ $data->photos }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Overall Store Lighting</th>
                        <td class="w-30">
                            @if ($data->store_lighting)
                                {{ $data->store_lighting }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Lighting On Products / Browser Lighting</th>
                        <td class="w-30">
                            @if ($data->lighting_products)
                                {{ $data->lighting_products }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Overall Store Vibe</th>
                        <td class="w-30">
                            @if ($data->store_vibe)
                                {{ $data->store_vibe }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Fragrance In Store</th>
                        <td class="w-30">
                            @if ($data->fragrance_in_store)
                                {{ $data->fragrance_in_store }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Music Inside Store?</th>
                        <td class="w-30">
                            @if ($data->music_inside_store)
                                {{ $data->music_inside_store }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Space Utilization</th>
                        <td class="w-30">
                            @if ($data->space_utilization)
                                {{ $data->space_utilization }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Store Layout</th>
                        <td class="w-30">
                            @if ($data->store_layout)
                                {{ $data->store_layout }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">The Store Is Of How Many Floors?</th>
                        <td class="w-30">
                            @if ($data->floors)
                                {{ $data->floors }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">AC & Ventilation</th>
                        <td class="w-30">
                            @if ($data->ac)
                                {{ $data->ac }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Mannequin Display</th>
                        <td class="w-30">
                            @if ($data->mannequin_display)
                                {{ $data->mannequin_display }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Seating Area (Inside Store)</th>
                        <td class="w-30">
                            @if ($data->seating_area)
                                {{ $data->seating_area }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Product Visibility</th>
                        <td class="w-30">
                            @if ($data->product_visiblity)
                                {{ $data->product_visiblity }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Store Signage And Graphics</th>
                        <td class="w-30">
                            @if ($data->store_signage)
                                {{ $data->store_signage }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Does The Store Have Independent Washroom ?</th>
                        <td class="w-30">
                            @if ($data->independent_washroom)
                                {{ $data->independent_washroom }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Any Remarks</th>
                        <td class="w-30">
                            @if ($data->any_remarks)
                                {{ $data->any_remarks }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Staff Behavior ( Initial Staff Behaviour)</th>
                        <td class="w-30">
                            @if ($data->staff_behaviour)
                                {{ $data->staff_behaviour }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Well Groomed</th>
                        <td class="w-30">
                            @if ($data->well_groomed)
                                {{ $data->well_groomed }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Standard Staff Uniform</th>
                        <td class="w-30">
                            @if ($data->standard_staff_uniform)
                                {{ $data->standard_staff_uniform }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Trial Room Assistance</th>
                        <td class="w-30">
                            @if ($data->trial_room_assistance)
                                {{ $data->trial_room_assistance }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">No. Of Customer At The Store Currently ?</th>
                        <td class="w-30">
                            @if ($data->number_customer)
                                {{ $data->number_customer }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Is The Staff Able To Handle The Customer ?</th>
                        <td class="w-30">
                            @if ($data->handel_customer)
                                {{ $data->handel_customer }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Knowledge Of Merchandise</th>
                        <td class="w-30">
                            @if ($data->knowledge_of_merchandise)
                                {{ $data->knowledge_of_merchandise }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Awareness Of Brand / Offers / In General</th>
                        <td class="w-30">
                            @if ($data->awareness_of_brand)
                                {{ $data->awareness_of_brand }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Proactive</th>
                        <td class="w-30">
                            @if ($data->proactive)
                                {{ $data->proactive }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Overall Customer Satisfaction (Staff Behavior Towards Customer/you)</th>
                        <td class="w-30">
                            @if ($data->customer_satisfaction)
                                {{ $data->customer_satisfaction }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Billing Counter Experience</th>
                        <td class="w-30">
                            @if ($data->billing_counter_experience)
                                {{ $data->billing_counter_experience }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Any Remarks On Staff Observation?</th>
                        <td class="w-30">
                            @if ($data->remarks_on_staff_observation)
                                {{ $data->remarks_on_staff_observation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Is The Store Currently Running Any Offers Or Discounts?</th>
                        <td class="w-30">
                            @if ($data->any_offers)
                                {{ $data->any_offers }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Current Offer In The Overall Store?</th>
                        <td class="w-30">
                            @if ($data->current_offer)
                                {{ $data->current_offer }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Return/Exchange Policy</th>
                        <td class="w-30">
                            @if ($data->exchange_policy)
                                {{ $data->exchange_policy }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Personal Occasion Discount Offered?</th>
                        <td class="w-30">
                            @if ($data->discount_offer)
                                {{ $data->discount_offer }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Reward Point Given?</th>
                        <td class="w-30">
                            @if ($data->reward_point_given)
                                {{ $data->reward_point_given }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Use Of Influencer/ Brand Marketing</th>
                        <td class="w-30">
                            @if ($data->use_of_influencer)
                                {{ $data->use_of_influencer }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Age Group Of Customers Currently Seen At The Store</th>
                        <td class="w-30">
                            @if ($data->age_group_of_customer)
                                {{ $data->age_group_of_customer }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Alteration Facility In Store</th>
                        <td class="w-30">
                            @if ($data->alteration_facility_in_store)
                                {{ $data->alteration_facility_in_store }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Any Remarks Sale / Marketing Strategy?</th>
                        <td class="w-30">
                            @if ($data->any_remarks_sale)
                                {{ $data->any_remarks_sale }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Sub-brands Offered?</th>
                        <td class="w-30">
                            @if ($data->sub_brand_offered)
                                {{ $data->sub_brand_offered }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Colour Palette Of The Entire Store At First Sight</th>
                        <td class="w-30">
                            @if ($data->colour_palette)
                                {{ $data->colour_palette }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Number Of Colourways Offered In Most Styles</th>
                        <td class="w-30">
                            @if ($data->number_of_colourways)
                                {{ $data->number_of_colourways }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Size Availability</th>
                        <td class="w-30">
                            @if ($data->type_of_error)
                                {{ $data->type_of_error }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Did You Find Engaging Priced Merchandise At The Store Front ?</th>
                        <td class="w-30">
                            @if ($data->size_availiblity)
                                {{ $data->size_availiblity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    {{-- Did You Find Engaging Priced Merchandise At The Store Front ? --}}
                    <tr>
                        <th class="w-20">Merchandise Availble In The Store</th>
                        <td class="w-30">
                            @if ($data->merchadise_available)
                                {{ $data->merchadise_available }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Types Of Fabric Available ?</th>
                        <td class="w-30">
                            @if ($data->types_of_fabric)
                                {{ $data->types_of_fabric }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Prints Observed?</th>
                        <td class="w-30">
                            @if ($data->prints_observed)
                                {{ $data->prints_observed }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Embroideries Observed?</th>
                        <td class="w-30">
                            @if ($data->embroideries_observed)
                                {{ $data->embroideries_observed }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Overall Quality Of Garments In The Store</th>
                        <td class="w-30">
                            @if ($data->quality_of_garments)
                                {{ $data->quality_of_garments }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Any Remarks On Product Observation?</th>
                        <td class="w-30">
                            @if ($data->remarks_on_product_observation)
                                {{ $data->remarks_on_product_observation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">The Entrance Of The Store (Display Of Garments)</th>
                        <td class="w-30">
                            @if ($data->entrance_of_the_store)
                                {{ $data->entrance_of_the_store }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Story Telling</th>
                        <td class="w-30">
                            @if ($data->story_telling)
                                {{ $data->story_telling }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Stock Display In The Entire Store</th>
                        <td class="w-30">
                            @if ($data->stock_display)
                                {{ $data->stock_display }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Spacing Of Clothes On The Rack</th>
                        <td class="w-30">
                            @if ($data->spacing_of_clothes)
                                {{ $data->spacing_of_clothes }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">How Many No. of Customers Can Browse At One Time In One Section?</th>
                        <td class="w-30">
                            @if ($data->how_many_no_of_customers)
                                {{ $data->how_many_no_of_customers }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Any Remarks On VM / Space Management</th>
                        <td class="w-30">
                            @if ($data->any_remarks_on_vm)
                                {{ $data->any_remarks_on_vm }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Suitable Brand Tagline</th>
                        <td class="w-30">
                            @if ($data->brand_tagline)
                                {{ $data->brand_tagline }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Type of Bill</th>
                        <td class="w-30">
                            @if ($data->type_of_ball)
                                {{ $data->type_of_ball }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Any Remarks On Branding?</th>
                        <td class="w-30">
                            @if ($data->any_ramrks_on_the_branding)
                                {{ $data->any_ramrks_on_the_branding }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Number Of Trial Rooms?</th>
                        <td class="w-30">
                            @if ($data->number_of_trial_rooms_)
                                {{ $data->number_of_trial_rooms_ }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        {{-- <th class="w-20">Number Of Trial Rooms?</th>
                        <td class="w-30">
                            @if ($data->type_of_error)
                                {{ $data->type_of_error }}
                            @else
                                Not Applicable
                            @endif
                        </td> --}}

                        <th class="w-20">Hygiene</th>
                        <td class="w-30">
                            @if ($data->hygiene_)
                                {{ $data->hygiene_ }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Ventilation</th>
                        <td class="w-30">
                            @if ($data->ventilation_)
                                {{ $data->ventilation_ }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Queue Outside The Trial Room</th>
                        <td class="w-30">
                            @if ($data->queue_outside_the_trial_room)
                                {{ $data->queue_outside_the_trial_room }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Mirror Size</th>
                        <td class="w-30">
                            @if ($data->mirror_size)
                                {{ $data->mirror_size }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Trial Room Lighting</th>
                        <td class="w-30">
                            @if ($data->trial_room_lighting)
                                {{ $data->trial_room_lighting }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Is Seating Inside The Trail Room Available?</th>
                        <td class="w-30">
                            @if ($data->trial_room_available)
                                {{ $data->trial_room_available }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Seating Around Trial Room Area (For Companions)</th>
                        <td class="w-30">
                            @if ($data->seating_around_trial_room)
                                {{ $data->seating_around_trial_room }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Cloth Hanger Inside The Trial Room Available?</th>
                        <td class="w-30">
                            @if ($data->cloth_hanger)
                                {{ $data->cloth_hanger }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Any Remarks On The Trial Room ?</th>
                        <td class="w-30">
                            @if ($data->any_remarks_on_the_trail_room)
                                {{ $data->any_remarks_on_the_trail_room }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> <tr>
                        <th class="w-20">Any Remarks / Comments Add on The Overall Store?</th>
                        <td class="w-30">
                            @if ($data->comments_on_hte_overall_store)
                                {{ $data->comments_on_hte_overall_store }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>


                </table>

                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                <div style="font-weight: 200">Details</div>
                {{-- </div> --}}
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">SR no.</th>
                            <th class="w-20">ListOfImpactingDocument</th>
                            <th class="w-20">Prepared By</th>
                            <th class="w-20">Checked By</th>
                            <th class="w-20">Approved By</th>
                        </tr>
                        @if ($grid_Data && is_array($grid_Data->data))
                            @foreach ($grid_Data->data as $grid_Data)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <td class="w-20">{{ isset($grid_Data['ListOfImpactingDocument']) ? $grid_Data['ListOfImpactingDocument'] : '' }}
                                    </td>
                                    <td class="w-20">{{ isset($grid_Data['PreparedBy']) ? $grid_Data['PreparedBy'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['CheckedBy']) ? $grid_Data['CheckedBy'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['ApprovedBy']) ? $grid_Data['ApprovedBy'] : '' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
                {{-- </div> --}}
            </div>






        </div>
    </div>

</body>

</html>
