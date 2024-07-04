<?php

namespace App\Http\Controllers;

use App\Models\FieldVisit;
use App\Models\FieldVisitAuditTrial;
use App\Models\FieldVisitGrid;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;

class FieldVisitController extends Controller
{
    //

    public function index()
    {

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        return view('frontend.field-visit.field_visit_new', compact('record_number'));
    }

    public function store(Request $request)
    {
        $data = new FieldVisit();
        $data->stage = '1';
        $data->status = 'Opened';
        // $data->type = "Field Visit Survey";
        $data->save_data = 1;
        $data->record = ((RecordNumber::first()->value('counter')) + 1);
        $data->division_code = $request->division_code;
        $data->initiator = $request->initiator;
        $data->intiation_date = $request->intiation_date;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->short_description = $request->short_description;
        $data->brand_name = $request->brand_name;
        $data->field_visitor = $request->field_visitor;
        $data->region = $request->region;
        $data->exact_location = $request->exact_location;
        $data->exact_address = $request->exact_address;

        if (! empty($request->photos)) {
            $files = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $name = $request->name.'photos'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $files[] = $name;
                }
            }
            $data->photos = json_encode($files);
        }

        $data->page_section = $request->page_section;
        $data->store_lighting = $request->store_lighting;
        $data->lighting_products = $request->lighting_products;
        $data->store_vibe = $request->store_vibe;
        $data->fragrance_in_store = $request->fragrance_in_store;
        $data->music_inside_store = $request->music_inside_store;
        $data->space_utilization = $request->space_utilization;
        $data->store_layout = $request->store_layout;
        $data->floors = $request->floors;
        $data->ac = $request->ac;
        $data->mannequin_display = $request->mannequin_display;
        $data->seating_area = $request->seating_area;
        $data->product_visiblity = $request->product_visiblity;
        $data->store_signage = $request->store_signage;
        $data->independent_washroom = $request->independent_washroom;
        $data->any_remarks = $request->any_remarks;
        $data->page_section1 = $request->page_section1;
        $data->staff_behaviour = $request->staff_behaviour;
        $data->well_groomed = $request->well_groomed;
        $data->standard_staff_uniform = $request->standard_staff_uniform;
        $data->trial_room_assistance = $request->trial_room_assistance;
        $data->number_customer = $request->number_customer;
        $data->handel_customer = $request->handel_customer;
        $data->knowledge_of_merchandise = $request->knowledge_of_merchandise;
        $data->awareness_of_brand = $request->awareness_of_brand;
        $data->proactive = $request->proactive;
        $data->customer_satisfaction = $request->customer_satisfaction;
        $data->billing_counter_experience = $request->billing_counter_experience;
        $data->remarks_on_staff_observation = $request->remarks_on_staff_observation;
        $data->page_sacetion_2 = $request->page_sacetion_2;
        $data->any_offers = $request->any_offers;
        $data->current_offer = $request->current_offer;
        $data->exchange_policy = $request->exchange_policy;
        $data->discount_offer = $request->discount_offer;
        $data->reward_point_given = $request->reward_point_given;
        $data->use_of_influencer = $request->use_of_influencer;
        $data->age_group_of_customer = $request->age_group_of_customer;
        $data->alteration_facility_in_store = $request->alteration_facility_in_store;
        $data->any_remarks_sale = $request->any_remarks_sale;
        $data->page_section_3 = $request->page_section_3;
        $data->sub_brand_offered = $request->sub_brand_offered;
        $data->colour_palette = $request->colour_palette;
        $data->number_of_colourways = $request->number_of_colourways;
        $data->size_availiblity = $request->size_availiblity;
        $data->engaging_price = $request->engaging_price;
        $data->merchadise_available = $request->merchadise_available;
        $data->types_of_fabric = $request->types_of_fabric;
        $data->prints_observed = $request->prints_observed;
        $data->embroideries_observed = $request->embroideries_observed;
        $data->quality_of_garments = $request->quality_of_garments;
        $data->remarks_on_product_observation = $request->remarks_on_product_observation;
        $data->page_section_4 = $request->page_section_4;
        $data->entrance_of_the_store = $request->entrance_of_the_store;
        $data->story_telling = $request->story_telling;
        $data->stock_display = $request->stock_display;
        $data->spacing_of_clothes = $request->spacing_of_clothes;
        $data->how_many_no_of_customers = $request->how_many_no_of_customers;
        $data->any_remarks_on_vm = $request->any_remarks_on_vm;
        $data->page_section_5 = $request->page_section_5;
        $data->brand_tagline = $request->brand_tagline;
        $data->type_of_ball = $request->type_of_ball;
        $data->any_ramrks_on_the_branding = $request->any_ramrks_on_the_branding;
        $data->page_section_6 = $request->page_section_6;
        $data->number_of_trial_rooms_ = $request->number_of_trial_rooms_;
        $data->hygiene_ = $request->hygiene_;
        $data->ventilation_ = $request->ventilation_;
        $data->queue_outside_the_trial_room = $request->queue_outside_the_trial_room;
        $data->mirror_size = $request->mirror_size;
        $data->trial_room_lighting = $request->trial_room_lighting;
        $data->trial_room_available = $request->trial_room_available;
        $data->seating_around_trial_room = $request->seating_around_trial_room;
        $data->cloth_hanger = $request->cloth_hanger;
        $data->any_remarks_on_the_trail_room = $request->any_remarks_on_the_trail_room;
        $data->comments_on_hte_overall_store = $request->comments_on_hte_overall_store;
        $data->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        if (! empty($data->date)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Date';
            $history->previous = 'Null';
            $history->current = $data->date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->time)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Time';
            $history->previous = 'Null';
            $history->current = $data->time;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->short_description)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous = 'Null';
            $history->current = $data->short_description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->brand_name)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Brand Name';
            $history->previous = 'Null';
            $history->current = $data->brand_name;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->field_visitor)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Name of field visitor';
            $history->previous = 'Null';
            $history->current = $data->field_visitor;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->region)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Region';
            $history->previous = 'Null';
            $history->current = $data->region;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->exact_location)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Exact Location';
            $history->previous = 'Null';
            $history->current = $data->exact_location;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->exact_address)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Exact Store Address';
            $history->previous = 'Null';
            $history->current = $data->exact_address;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->photos)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Photos (Store From Outside, Racks, Window Display, Overall VM)';
            $history->previous = 'Null';
            $history->current = $data->photos;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->store_lighting)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Overall Store Lighting';
            $history->previous = 'Null';
            $history->current = $data->store_lighting;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->lighting_products)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Lighting On Products / Browser Lighting';
            $history->previous = 'Null';
            $history->current = $data->lighting_products;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->store_vibe)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Overall Store Vibe';
            $history->previous = 'Null';
            $history->current = $data->store_vibe;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->fragrance_in_store)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Fragrance In Store';
            $history->previous = 'Null';
            $history->current = $data->fragrance_in_store;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->music_inside_store)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Music Inside Store?';
            $history->previous = 'Null';
            $history->current = $data->music_inside_store;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->space_utilization)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Space Utilization';
            $history->previous = 'Null';
            $history->current = $data->space_utilization;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->store_layout)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Store Layout';
            $history->previous = 'Null';
            $history->current = $data->store_layout;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->floors)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'The Store Is of How Many Floors?';
            $history->previous = 'Null';
            $history->current = $data->floors;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->ac)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'AC & Ventilation';
            $history->previous = 'Null';
            $history->current = $data->ac;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->mannequin_display)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Mannequin Display';
            $history->previous = 'Null';
            $history->current = $data->mannequin_display;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->seating_area)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Seating Area (Inside Store)';
            $history->previous = 'Null';
            $history->current = $data->seating_area;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->product_visiblity)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Product Visibility';
            $history->previous = 'Null';
            $history->current = $data->product_visiblity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->store_signage)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Store Signage and Graphics';
            $history->previous = 'Null';
            $history->current = $data->store_signage;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->independent_washroom)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Does The Store Have Independent Washroom ?';
            $history->previous = 'Null';
            $history->current = $data->independent_washroom;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->any_remarks)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks';
            $history->previous = 'Null';
            $history->current = $data->any_remarks;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->staff_behaviour)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Staff Behavior ( Initial Staff Behaviour)';
            $history->previous = 'Null';
            $history->current = $data->staff_behaviour;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->well_groomed)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Well Groomed';
            $history->previous = 'Null';
            $history->current = $data->well_groomed;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->standard_staff_uniform)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Standard Staff Uniform';
            $history->previous = 'Null';
            $history->current = $data->standard_staff_uniform;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->trial_room_assistance)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Trial Room Assistance';
            $history->previous = 'Null';
            $history->current = $data->trial_room_assistance;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->number_customer)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'No. of Customer At the Store Currently ?';
            $history->previous = 'Null';
            $history->current = $data->number_customer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->handel_customer)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Is the Staff Able to Handle The Customer ?';
            $history->previous = 'Null';
            $history->current = $data->handel_customer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->knowledge_of_merchandise)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Knowledge of Merchandise';
            $history->previous = 'Null';
            $history->current = $data->knowledge_of_merchandise;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->awareness_of_brand)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Awareness of Brand / Offers / In General';
            $history->previous = 'Null';
            $history->current = $data->awareness_of_brand;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->proactive)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Proactive';
            $history->previous = 'Null';
            $history->current = $data->proactive;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->customer_satisfaction)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Overall Customer Satisfaction (Staff Behavior Towards Customer/you)';
            $history->previous = 'Null';
            $history->current = $data->customer_satisfaction;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->billing_counter_experience)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Billing Counter Experience';
            $history->previous = 'Null';
            $history->current = $data->billing_counter_experience;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->remarks_on_staff_observation)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks on Staff Observation?';
            $history->previous = 'Null';
            $history->current = $data->remarks_on_staff_observation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->any_offers)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Is the Store Currently Running Any Offers Or Discounts?';
            $history->previous = 'Null';
            $history->current = $data->any_offers;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->current_offer)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Current Offer In the Overall Store?';
            $history->previous = 'Null';
            $history->current = $data->current_offer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->exchange_policy)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Return/Exchange Policy';
            $history->previous = 'Null';
            $history->current = $data->exchange_policy;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->discount_offer)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Personal Occasion Discount Offered?';
            $history->previous = 'Null';
            $history->current = $data->discount_offer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->reward_point_given)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Reward Point Given?';
            $history->previous = 'Null';
            $history->current = $data->reward_point_given;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->use_of_influencer)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Use of Influencer/ Brand Marketing';
            $history->previous = 'Null';
            $history->current = $data->use_of_influencer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->age_group_of_customer)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Age Group of Customers Currently Seen At the Store';
            $history->previous = 'Null';
            $history->current = $data->age_group_of_customer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->alteration_facility_in_store)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Alteration Facility In Store';
            $history->previous = 'Null';
            $history->current = $data->alteration_facility_in_store;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->any_remarks_sale)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks Sale / Marketing Strategy?';
            $history->previous = 'Null';
            $history->current = $data->any_remarks_sale;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->sub_brand_offered)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Sub-brands Offered?';
            $history->previous = 'Null';
            $history->current = $data->sub_brand_offered;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->colour_palette)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Colour Palette of the Entire Store At First Sight';
            $history->previous = 'Null';
            $history->current = $data->colour_palette;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->number_of_colourways)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Number of Colourways Offered In Most Styles';
            $history->previous = 'Null';
            $history->current = $data->number_of_colourways;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->size_availiblity)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Size Availability';
            $history->previous = 'Null';
            $history->current = $data->size_availiblity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->engaging_price)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Did You Find Engaging Priced Merchandise At the Store Front ?';
            $history->previous = 'Null';
            $history->current = $data->engaging_price;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->merchadise_available)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Merchandise Availble In the Store';
            $history->previous = 'Null';
            $history->current = $data->merchadise_available;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->types_of_fabric)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Types of Fabric Available ?';
            $history->previous = 'Null';
            $history->current = $data->types_of_fabric;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->prints_observed)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Prints Observed?';
            $history->previous = 'Null';
            $history->current = $data->prints_observed;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->embroideries_observed)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Embroideries Observed?';
            $history->previous = 'Null';
            $history->current = $data->embroideries_observed;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->quality_of_garments)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Overall Quality of Garments In the Store';
            $history->previous = 'Null';
            $history->current = $data->quality_of_garments;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->remarks_on_product_observation)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks On Product Observation?';
            $history->previous = 'Null';
            $history->current = $data->remarks_on_product_observation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->entrance_of_the_store)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'The Entrance of the Store (Display of Garments)';
            $history->previous = 'Null';
            $history->current = $data->entrance_of_the_store;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->story_telling)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Story Telling';
            $history->previous = 'Null';
            $history->current = $data->story_telling;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->stock_display)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Stock Display In the Entire Store';
            $history->previous = 'Null';
            $history->current = $data->stock_display;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->spacing_of_clothes)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Spacing of Clothes On The Rack';
            $history->previous = 'Null';
            $history->current = $data->spacing_of_clothes;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->how_many_no_of_customers)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'How Many No. of Customers Can Browse At One Time In One Section?';
            $history->previous = 'Null';
            $history->current = $data->how_many_no_of_customers;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->any_remarks_on_vm)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks On VM / Space Management';
            $history->previous = 'Null';
            $history->current = $data->any_remarks_on_vm;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->brand_tagline)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Suitable Brand Tagline';
            $history->previous = 'Null';
            $history->current = $data->brand_tagline;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->type_of_ball)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Type of Bill';
            $history->previous = 'Null';
            $history->current = $data->type_of_ball;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->any_ramrks_on_the_branding)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks On Branding?';
            $history->previous = 'Null';
            $history->current = $data->any_ramrks_on_the_branding;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->number_of_trial_rooms_)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Number of Trial Rooms?';
            $history->previous = 'Null';
            $history->current = $data->number_of_trial_rooms_;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->hygiene_)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Hygiene';
            $history->previous = 'Null';
            $history->current = $data->hygiene_;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->ventilation_)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Ventilation';
            $history->previous = 'Null';
            $history->current = $data->ventilation_;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->queue_outside_the_trial_room)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Queue Outside the Trial Room';
            $history->previous = 'Null';
            $history->current = $data->queue_outside_the_trial_room;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->mirror_size)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Mirror Size';
            $history->previous = 'Null';
            $history->current = $data->mirror_size;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->trial_room_lighting)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Trial Room Lighting';
            $history->previous = 'Null';
            $history->current = $data->trial_room_lighting;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->trial_room_available)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Is Seating Inside the Trail Room Available?';
            $history->previous = 'Null';
            $history->current = $data->trial_room_available;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->seating_around_trial_room)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Seating Around Trial Room Area (For Companions)';
            $history->previous = 'Null';
            $history->current = $data->seating_around_trial_room;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->cloth_hanger)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Cloth Hanger Inside the Trial Room Available?';
            $history->previous = 'Null';
            $history->current = $data->cloth_hanger;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->any_remarks_on_the_trail_room)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks On The Trial Room ?';
            $history->previous = 'Null';
            $history->current = $data->any_remarks_on_the_trail_room;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->comments_on_hte_overall_store)) {
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $data->id;
            $history->activity_type = 'Any Remarks / Comments Add on The Overall Store?';
            $history->previous = 'Null';
            $history->current = $data->comments_on_hte_overall_store;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }

        //=========================================grid============================================

        $fieldvisit_id = $data->id;
        $newDataGridFiledVisit = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details1'])->firstOrCreate();
        $newDataGridFiledVisit->fv_id = $fieldvisit_id;
        $newDataGridFiledVisit->identifier = 'details1';
        $newDataGridFiledVisit->data = $request->details1;
        $newDataGridFiledVisit->save();

        $fieldvisit_id = $data->id;
        $newDataGridFiledVisit = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details2'])->firstOrCreate();
        $newDataGridFiledVisit->fv_id = $fieldvisit_id;
        $newDataGridFiledVisit->identifier = 'details2';
        $newDataGridFiledVisit->data = $request->details2;
        $newDataGridFiledVisit->save();

        //=========================================================================================

        // return back();

        toastr()->success('Record is created Successfully');

        return redirect(url('rcms/qms-dashboard'));

    }

    public function show($id)
    {
        $data = FieldVisit::find($id);
        $fieldvisit_id = $data->id;
        $grid_Data = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details1'])->first();
        $grid_Data2 = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details2'])->first();

        return view('frontend.field-visit.field_visit_view', compact('data', 'grid_Data', 'grid_Data2'));
    }

    public function update(Request $request, $id)
    {
        $lastDocument = FieldVisit::find($id);
        $data = FieldVisit::find($id);
        $lastdata = FieldVisit::find($id);
        $lastDocumentRecord = FieldVisit::find($data->id);
        $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;

        $data = FieldVisit::find($id);
        // dd($data);
        $data->save_data++;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->short_description = $request->short_description;
        $data->brand_name = $request->brand_name;
        $data->field_visitor = $request->field_visitor;
        $data->region = $request->region;
        $data->exact_location = $request->exact_location;
        $data->exact_address = $request->exact_address;
        $data->page_section = $request->page_section;
        $data->photos = $request->photos;
        $data->any_remarks_on_vm = $request->any_remarks_on_vm;
        $data->any_ramrks_on_the_branding = $request->any_ramrks_on_the_branding;
        $data->store_lighting = $request->store_lighting;
        $data->lighting_products = $request->lighting_products;
        $data->store_vibe = $request->store_vibe;
        $data->fragrance_in_store = $request->fragrance_in_store;
        $data->music_inside_store = $request->music_inside_store;
        $data->space_utilization = $request->space_utilization;
        $data->store_layout = $request->store_layout;
        $data->floors = $request->floors;
        $data->ac = $request->ac;
        $data->mannequin_display = $request->mannequin_display;
        $data->seating_area = $request->seating_area;
        $data->product_visiblity = $request->product_visiblity;
        $data->store_signage = $request->store_signage;
        $data->independent_washroom = $request->independent_washroom;
        $data->any_remarks = $request->any_remarks;
        $data->page_section1 = $request->page_section1;
        $data->staff_behaviour = $request->staff_behaviour;
        $data->well_groomed = $request->well_groomed;
        $data->standard_staff_uniform = $request->standard_staff_uniform;
        $data->trial_room_assistance = $request->trial_room_assistance;
        $data->number_customer = $request->number_customer;
        $data->handel_customer = $request->handel_customer;
        $data->knowledge_of_merchandise = $request->knowledge_of_merchandise;
        $data->awareness_of_brand = $request->awareness_of_brand;
        $data->proactive = $request->proactive;
        $data->customer_satisfaction = $request->customer_satisfaction;
        $data->billing_counter_experience = $request->billing_counter_experience;
        $data->remarks_on_staff_observation = $request->remarks_on_staff_observation;
        $data->page_sacetion_2 = $request->page_sacetion_2;
        $data->any_offers = $request->any_offers;
        $data->current_offer = $request->current_offer;
        $data->exchange_policy = $request->exchange_policy;
        $data->discount_offer = $request->discount_offer;
        $data->reward_point_given = $request->reward_point_given;
        $data->use_of_influencer = $request->use_of_influencer;
        $data->age_group_of_customer = $request->age_group_of_customer;
        $data->alteration_facility_in_store = $request->alteration_facility_in_store;
        $data->any_remarks_sale = $request->any_remarks_sale;
        $data->page_section_3 = $request->page_section_3;
        $data->sub_brand_offered = $request->sub_brand_offered;
        $data->colour_palette = $request->colour_palette;
        $data->number_of_colourways = $request->number_of_colourways;
        $data->size_availiblity = $request->size_availiblity;
        $data->engaging_price = $request->engaging_price;
        $data->merchadise_available = $request->merchadise_available;
        $data->types_of_fabric = $request->types_of_fabric;
        $data->prints_observed = $request->prints_observed;
        $data->embroideries_observed = $request->embroideries_observed;
        $data->quality_of_garments = $request->quality_of_garments;
        $data->remarks_on_product_observation = $request->remarks_on_product_observation;
        $data->page_section_4 = $request->page_section_4;
        $data->entrance_of_the_store = $request->entrance_of_the_store;
        $data->story_telling = $request->story_telling;
        $data->stock_display = $request->stock_display;
        $data->spacing_of_clothes = $request->spacing_of_clothes;
        $data->how_many_no_of_customers = $request->how_many_no_of_customers;
        $data->page_section_5 = $request->page_section_5;
        $data->brand_tagline = $request->brand_tagline;
        $data->type_of_ball = $request->type_of_ball;
        $data->page_section_6 = $request->page_section_6;
        $data->number_of_trial_rooms_ = $request->number_of_trial_rooms_;
        $data->hygiene_ = $request->hygiene_;
        $data->ventilation_ = $request->ventilation_;
        $data->queue_outside_the_trial_room = $request->queue_outside_the_trial_room;
        $data->mirror_size = $request->mirror_size;
        $data->trial_room_lighting = $request->trial_room_lighting;
        $data->trial_room_available = $request->trial_room_available;
        $data->seating_around_trial_room = $request->seating_around_trial_room;
        $data->cloth_hanger = $request->cloth_hanger;
        $data->any_remarks_on_the_trail_room = $request->any_remarks_on_the_trail_room;
        $data->comments_on_hte_overall_store = $request->comments_on_hte_overall_store;
        $data->update();

        if ($lastDocument->date != $data->date || ! empty($request->date_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Date')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Date';
            $history->previous = $lastDocument->date;
            $history->current = $data->date;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->time != $data->time || ! empty($request->time_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Time')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Time';
            $history->previous = $lastDocument->time;
            $history->current = $data->time;
            $history->comment = $request->time_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->short_description != $data->short_description || ! empty($request->short_description_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Short Description')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $data->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->brand_name != $data->brand_name || ! empty($request->brand_name_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Brand Name')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Brand Name';
            $history->previous = $lastDocument->brand_name;
            $history->current = $data->brand_name;
            $history->comment = $request->brand_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->field_visitor != $data->field_visitor || ! empty($request->field_visitor_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Name of field visitor')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Name of field visitor';
            $history->previous = $lastDocument->field_visitor;
            $history->current = $data->field_visitor;
            $history->comment = $request->field_visitor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->region != $data->region || ! empty($request->region_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Region')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Region';
            $history->previous = $lastDocument->region;
            $history->current = $data->region;
            $history->comment = $request->region_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->exact_location != $data->exact_location || ! empty($request->exact_location_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Exact Location')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Exact Location';
            $history->previous = $lastDocument->exact_location;
            $history->current = $data->exact_location;
            $history->comment = $request->exact_location_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->exact_address != $data->exact_address || ! empty($request->exact_address_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Exact Store Address')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Exact Store Address';
            $history->previous = $lastDocument->exact_address;
            $history->current = $data->exact_address;
            $history->comment = $request->exact_address_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->photos != $data->photos || ! empty($request->photos_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Photos (Store From Outside, Racks, Window Display, Overall VM)')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Photos (Store From Outside, Racks, Window Display, Overall VM)';
            $history->previous = $lastDocument->photos;
            $history->current = $data->photos;
            $history->comment = $request->photos_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->store_lighting != $data->store_lighting || ! empty($request->store_lighting_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Overall Store Lighting')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Overall Store Lighting';
            $history->previous = $lastDocument->store_lighting;
            $history->current = $data->store_lighting;
            $history->comment = $request->store_lighting_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->lighting_products != $data->lighting_products || ! empty($request->lighting_products_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Lighting On Products / Browser Lighting')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Lighting On Products / Browser Lighting';
            $history->previous = $lastDocument->lighting_products;
            $history->current = $data->lighting_products;
            $history->comment = $request->lighting_products_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->store_vibe != $data->store_vibe || ! empty($request->store_vibe_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Overall Store Vibe')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Overall Store Vibe';
            $history->previous = $lastDocument->store_vibe;
            $history->current = $data->store_vibe;
            $history->comment = $request->store_vibe_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->fragrance_in_store != $data->fragrance_in_store || ! empty($request->fragrance_in_store_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Fragrance In Store')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Fragrance In Store';
            $history->previous = $lastDocument->fragrance_in_store;
            $history->current = $data->fragrance_in_store;
            $history->comment = $request->fragrance_in_store_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->music_inside_store != $data->music_inside_store || ! empty($request->music_inside_store_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Music Inside Store?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Music Inside Store?';
            $history->previous = $lastDocument->music_inside_store;
            $history->current = $data->music_inside_store;
            $history->comment = $request->music_inside_store_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->space_utilization != $data->space_utilization || ! empty($request->space_utilization_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Space Utilization')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Space Utilization';
            $history->previous = $lastDocument->space_utilization;
            $history->current = $data->space_utilization;
            $history->comment = $request->space_utilization_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->store_layout != $data->store_layout || ! empty($request->store_layout_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Store Layout')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Store Layout';
            $history->previous = $lastDocument->store_layout;
            $history->current = $data->store_layout;
            $history->comment = $request->store_layout_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->floors != $data->floors || ! empty($request->floors_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'The Store Is of How Many Floors?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'The Store Is of How Many Floors?';
            $history->previous = $lastDocument->floors;
            $history->current = $data->floors;
            $history->comment = $request->floors_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->ac != $data->ac || ! empty($request->ac_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'AC & Ventilation')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'AC & Ventilation';
            $history->previous = $lastDocument->ac;
            $history->current = $data->ac;
            $history->comment = $request->ac_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->mannequin_display != $data->mannequin_display || ! empty($request->mannequin_display_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Mannequin Display')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Mannequin Display';
            $history->previous = $lastDocument->mannequin_display;
            $history->current = $data->mannequin_display;
            $history->comment = $request->mannequin_display_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->seating_area != $data->seating_area || ! empty($request->seating_area_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Seating Area (Inside Store)')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Seating Area (Inside Store)';
            $history->previous = $lastDocument->seating_area;
            $history->current = $data->seating_area;
            $history->comment = $request->seating_area_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->product_visiblity != $data->product_visiblity || ! empty($request->product_visiblity_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Product Visibility')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Product Visibility';
            $history->previous = $lastDocument->product_visiblity;
            $history->current = $data->product_visiblity;
            $history->comment = $request->product_visiblity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->store_signage != $data->store_signage || ! empty($request->store_signage_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Store Signage and Graphics')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Store Signage and Graphics';
            $history->previous = $lastDocument->store_signage;
            $history->current = $data->store_signage;
            $history->comment = $request->store_signage_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->independent_washroom != $data->independent_washroom || ! empty($request->independent_washroom_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Does The Store Have Independent Washroom ?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Does The Store Have Independent Washroom ?';
            $history->previous = $lastDocument->independent_washroom;
            $history->current = $data->independent_washroom;
            $history->comment = $request->independent_washroom_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->any_remarks != $data->any_remarks || ! empty($request->any_remarks_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks';
            $history->previous = $lastDocument->any_remarks;
            $history->current = $data->any_remarks;
            $history->comment = $request->any_remarks_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->staff_behaviour != $data->staff_behaviour || ! empty($request->staff_behaviour_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Staff Behavior ( Initial Staff Behaviour)')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Staff Behavior ( Initial Staff Behaviour)';
            $history->previous = $lastDocument->staff_behaviour;
            $history->current = $data->staff_behaviour;
            $history->comment = $request->staff_behaviour_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->well_groomed != $data->well_groomed || ! empty($request->well_groomed_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Well Groomed')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Well Groomed';
            $history->previous = $lastDocument->well_groomed;
            $history->current = $data->well_groomed;
            $history->comment = $request->well_groomed_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->standard_staff_uniform != $data->standard_staff_uniform || ! empty($request->standard_staff_uniform_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Standard Staff Uniform')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Standard Staff Uniform';
            $history->previous = $lastDocument->standard_staff_uniform;
            $history->current = $data->standard_staff_uniform;
            $history->comment = $request->standard_staff_uniform_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->trial_room_assistance != $data->trial_room_assistance || ! empty($request->trial_room_assistance_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Trial Room Assistance')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Trial Room Assistance';
            $history->previous = $lastDocument->trial_room_assistance;
            $history->current = $data->trial_room_assistance;
            $history->comment = $request->trial_room_assistance_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->number_customer != $data->number_customer || ! empty($request->number_customer_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'No. of Customer At the Store Currently ?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'No. of Customer At the Store Currently ?';
            $history->previous = $lastDocument->number_customer;
            $history->current = $data->number_customer;
            $history->comment = $request->number_customer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->handel_customer != $data->handel_customer || ! empty($request->handel_customer_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Is the Staff Able to Handle The Customer ?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Is the Staff Able to Handle The Customer ?';
            $history->previous = $lastDocument->handel_customer;
            $history->current = $data->handel_customer;
            $history->comment = $request->handel_customer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->knowledge_of_merchandise != $data->knowledge_of_merchandise || ! empty($request->knowledge_of_merchandise_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Knowledge of Merchandise')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Knowledge of Merchandise';
            $history->previous = $lastDocument->knowledge_of_merchandise;
            $history->current = $data->knowledge_of_merchandise;
            $history->comment = $request->knowledge_of_merchandise_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->awareness_of_brand != $data->awareness_of_brand || ! empty($request->awareness_of_brand_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Awareness of Brand / Offers / In General')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Awareness of Brand / Offers / In General';
            $history->previous = $lastDocument->awareness_of_brand;
            $history->current = $data->awareness_of_brand;
            $history->comment = $request->awareness_of_brand_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->proactive != $data->proactive || ! empty($request->proactive_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Proactive')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Proactive';
            $history->previous = $lastDocument->proactive;
            $history->current = $data->proactive;
            $history->comment = $request->proactive_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->customer_satisfaction != $data->customer_satisfaction || ! empty($request->customer_satisfaction_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Overall Customer Satisfaction (Staff Behavior Towards Customer/you)')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Overall Customer Satisfaction (Staff Behavior Towards Customer/you)';
            $history->previous = $lastDocument->customer_satisfaction;
            $history->current = $data->customer_satisfaction;
            $history->comment = $request->customer_satisfaction_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->billing_counter_experience != $data->billing_counter_experience || ! empty($request->billing_counter_experience_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Billing Counter Experience')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Billing Counter Experience';
            $history->previous = $lastDocument->billing_counter_experience;
            $history->current = $data->billing_counter_experience;
            $history->comment = $request->billing_counter_experience_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->remarks_on_staff_observation != $data->remarks_on_staff_observation || ! empty($request->remarks_on_staff_observation_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks on Staff Observation?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks on Staff Observation?';
            $history->previous = $lastDocument->remarks_on_staff_observation;
            $history->current = $data->remarks_on_staff_observation;
            $history->comment = $request->remarks_on_staff_observation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->any_offers != $data->any_offers || ! empty($request->any_offers_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Is the Store Currently Running Any Offers Or Discounts?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Is the Store Currently Running Any Offers Or Discounts?';
            $history->previous = $lastDocument->any_offers;
            $history->current = $data->any_offers;
            $history->comment = $request->any_offers_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->current_offer != $data->current_offer || ! empty($request->current_offer_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Current Offer In the Overall Store?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Current Offer In the Overall Store?';
            $history->previous = $lastDocument->current_offer;
            $history->current = $data->current_offer;
            $history->comment = $request->current_offer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->exchange_policy != $data->exchange_policy || ! empty($request->exchange_policy_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Return/Exchange Policy')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Return/Exchange Policy';
            $history->previous = $lastDocument->exchange_policy;
            $history->current = $data->exchange_policy;
            $history->comment = $request->exchange_policy_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->discount_offer != $data->discount_offer || ! empty($request->discount_offer_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Personal Occasion Discount Offered?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Personal Occasion Discount Offered?';
            $history->previous = $lastDocument->discount_offer;
            $history->current = $data->discount_offer;
            $history->comment = $request->discount_offer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->reward_point_given != $data->reward_point_given || ! empty($request->reward_point_given_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Reward Point Given?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Reward Point Given?';
            $history->previous = $lastDocument->reward_point_given;
            $history->current = $data->reward_point_given;
            $history->comment = $request->reward_point_given_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->use_of_influencer != $data->use_of_influencer || ! empty($request->use_of_influencer_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Use of Influencer/ Brand Marketing')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Use of Influencer/ Brand Marketing';
            $history->previous = $lastDocument->use_of_influencer;
            $history->current = $data->use_of_influencer;
            $history->comment = $request->use_of_influencer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->age_group_of_customer != $data->age_group_of_customer || ! empty($request->age_group_of_customer_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Age Group of Customers Currently Seen At the Store')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Age Group of Customers Currently Seen At the Store';
            $history->previous = $lastDocument->age_group_of_customer;
            $history->current = $data->age_group_of_customer;
            $history->comment = $request->age_group_of_customer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->alteration_facility_in_store != $data->alteration_facility_in_store || ! empty($request->alteration_facility_in_store_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Alteration Facility In Store')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Alteration Facility In Store';
            $history->previous = $lastDocument->alteration_facility_in_store;
            $history->current = $data->alteration_facility_in_store;
            $history->comment = $request->alteration_facility_in_store_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->any_remarks_sale != $data->any_remarks_sale || ! empty($request->any_remarks_sale_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks Sale / Marketing Strategy?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks Sale / Marketing Strategy?';
            $history->previous = $lastDocument->any_remarks_sale;
            $history->current = $data->any_remarks_sale;
            $history->comment = $request->any_remarks_sale_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->sub_brand_offered != $data->sub_brand_offered || ! empty($request->sub_brand_offered_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Sub-brands Offered?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Sub-brands Offered?';
            $history->previous = $lastDocument->sub_brand_offered;
            $history->current = $data->sub_brand_offered;
            $history->comment = $request->sub_brand_offered_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->colour_palette != $data->colour_palette || ! empty($request->colour_palette_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Colour Palette of the Entire Store At First Sight')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Colour Palette of the Entire Store At First Sight';
            $history->previous = $lastDocument->colour_palette;
            $history->current = $data->colour_palette;
            $history->comment = $request->colour_palette_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->number_of_colourways != $data->number_of_colourways || ! empty($request->number_of_colourways_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Number of Colourways Offered In Most Styles')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Number of Colourways Offered In Most Styles';
            $history->previous = $lastDocument->number_of_colourways;
            $history->current = $data->number_of_colourways;
            $history->comment = $request->number_of_colourways_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->size_availiblity != $data->size_availiblity || ! empty($request->size_availiblity_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Size Availability')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Size Availability';
            $history->previous = $lastDocument->size_availiblity;
            $history->current = $data->size_availiblity;
            $history->comment = $request->size_availiblity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->engaging_price != $data->engaging_price || ! empty($request->engaging_price_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Did You Find Engaging Priced Merchandise At the Store Front ?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Did You Find Engaging Priced Merchandise At the Store Front ?';
            $history->previous = $lastDocument->engaging_price;
            $history->current = $data->engaging_price;
            $history->comment = $request->engaging_price_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->merchadise_available != $data->merchadise_available || ! empty($request->merchadise_available_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Merchandise Availble In the Store')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Merchandise Availble In the Store';
            $history->previous = $lastDocument->merchadise_available;
            $history->current = $data->merchadise_available;
            $history->comment = $request->merchadise_available_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->types_of_fabric != $data->types_of_fabric || ! empty($request->types_of_fabric_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Types of Fabric Available ?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Types of Fabric Available ?';
            $history->previous = $lastDocument->types_of_fabric;
            $history->current = $data->types_of_fabric;
            $history->comment = $request->types_of_fabric_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->prints_observed != $data->prints_observed || ! empty($request->prints_observed_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Prints Observed?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Prints Observed?';
            $history->previous = $lastDocument->prints_observed;
            $history->current = $data->prints_observed;
            $history->comment = $request->prints_observed_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->embroideries_observed != $data->embroideries_observed || ! empty($request->embroideries_observed_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Embroideries Observed?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Embroideries Observed?';
            $history->previous = $lastDocument->embroideries_observed;
            $history->current = $data->embroideries_observed;
            $history->comment = $request->embroideries_observed_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->quality_of_garments != $data->quality_of_garments || ! empty($request->quality_of_garments_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Overall Quality of Garments In the Store')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Overall Quality of Garments In the Store';
            $history->previous = $lastDocument->quality_of_garments;
            $history->current = $data->quality_of_garments;
            $history->comment = $request->quality_of_garments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->remarks_on_product_observation != $data->remarks_on_product_observation || ! empty($request->remarks_on_product_observation_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks On Product Observation?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks On Product Observation?';
            $history->previous = $lastDocument->remarks_on_product_observation;
            $history->current = $data->remarks_on_product_observation;
            $history->comment = $request->remarks_on_product_observation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->entrance_of_the_store != $data->entrance_of_the_store || ! empty($request->entrance_of_the_store_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'The Entrance of the Store (Display of Garments)')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'The Entrance of the Store (Display of Garments)';
            $history->previous = $lastDocument->entrance_of_the_store;
            $history->current = $data->entrance_of_the_store;
            $history->comment = $request->entrance_of_the_store_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->story_telling != $data->story_telling || ! empty($request->story_telling_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Story Telling')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Story Telling';
            $history->previous = $lastDocument->story_telling;
            $history->current = $data->story_telling;
            $history->comment = $request->story_telling_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->stock_display != $data->stock_display || ! empty($request->stock_display_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Stock Display In the Entire Store')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Stock Display In the Entire Store';
            $history->previous = $lastDocument->stock_display;
            $history->current = $data->stock_display;
            $history->comment = $request->stock_display_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->spacing_of_clothes != $data->spacing_of_clothes || ! empty($request->spacing_of_clothes_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Spacing of Clothes On The Rack')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Spacing of Clothes On The Rack';
            $history->previous = $lastDocument->spacing_of_clothes;
            $history->current = $data->spacing_of_clothes;
            $history->comment = $request->spacing_of_clothes_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->how_many_no_of_customers != $data->how_many_no_of_customers || ! empty($request->how_many_no_of_customers_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'How Many No. of Customers Can Browse At One Time In One Section?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'How Many No. of Customers Can Browse At One Time In One Section?';
            $history->previous = $lastDocument->how_many_no_of_customers;
            $history->current = $data->how_many_no_of_customers;
            $history->comment = $request->how_many_no_of_customers_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->any_remarks_on_vm != $data->any_remarks_on_vm || ! empty($request->any_remarks_on_vm_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks On VM / Space Management')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks On VM / Space Management';
            $history->previous = $lastDocument->any_remarks_on_vm;
            $history->current = $data->any_remarks_on_vm;
            $history->comment = $request->any_remarks_on_vm_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->brand_tagline != $data->brand_tagline || ! empty($request->brand_tagline_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Suitable Brand Tagline')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Suitable Brand Tagline';
            $history->previous = $lastDocument->brand_tagline;
            $history->current = $data->brand_tagline;
            $history->comment = $request->brand_tagline_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->type_of_ball != $data->type_of_ball || ! empty($request->type_of_ball_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Type of Bill')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Type of Bill';
            $history->previous = $lastDocument->type_of_ball;
            $history->current = $data->type_of_ball;
            $history->comment = $request->type_of_ball_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->any_ramrks_on_the_branding != $data->any_ramrks_on_the_branding || ! empty($request->any_ramrks_on_the_branding_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks On Branding?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks On Branding?';
            $history->previous = $lastDocument->any_ramrks_on_the_branding;
            $history->current = $data->any_ramrks_on_the_branding;
            $history->comment = $request->any_ramrks_on_the_branding_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->number_of_trial_rooms_ != $data->number_of_trial_rooms_ || ! empty($request->number_of_trial_rooms__comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Number of Trial Rooms?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Number of Trial Rooms?';
            $history->previous = $lastDocument->number_of_trial_rooms_;
            $history->current = $data->number_of_trial_rooms_;
            $history->comment = $request->number_of_trial_rooms__comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->hygiene_ != $data->hygiene_ || ! empty($request->hygiene__comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Hygiene')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Hygiene';
            $history->previous = $lastDocument->hygiene_;
            $history->current = $data->hygiene_;
            $history->comment = $request->hygiene__comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->ventilation_ != $data->ventilation_ || ! empty($request->ventilation__comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Ventilation')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Ventilation';
            $history->previous = $lastDocument->ventilation_;
            $history->current = $data->ventilation_;
            $history->comment = $request->ventilation__comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->queue_outside_the_trial_room != $data->queue_outside_the_trial_room || ! empty($request->queue_outside_the_trial_room_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Queue Outside the Trial Room')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Queue Outside the Trial Room';
            $history->previous = $lastDocument->queue_outside_the_trial_room;
            $history->current = $data->queue_outside_the_trial_room;
            $history->comment = $request->queue_outside_the_trial_room_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->mirror_size != $data->mirror_size || ! empty($request->mirror_size_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Mirror Size')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Mirror Size';
            $history->previous = $lastDocument->mirror_size;
            $history->current = $data->mirror_size;
            $history->comment = $request->mirror_size_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->trial_room_lighting != $data->trial_room_lighting || ! empty($request->trial_room_lighting_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Trial Room Lighting')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Trial Room Lighting';
            $history->previous = $lastDocument->trial_room_lighting;
            $history->current = $data->trial_room_lighting;
            $history->comment = $request->trial_room_lighting_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->trial_room_available != $data->trial_room_available || ! empty($request->trial_room_available_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Is Seating Inside the Trail Room Available?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Is Seating Inside the Trail Room Available?';
            $history->previous = $lastDocument->trial_room_available;
            $history->current = $data->trial_room_available;
            $history->comment = $request->trial_room_available_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->seating_around_trial_room != $data->seating_around_trial_room || ! empty($request->seating_around_trial_room_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Seating Around Trial Room Area (For Companions)')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Seating Around Trial Room Area (For Companions)';
            $history->previous = $lastDocument->seating_around_trial_room;
            $history->current = $data->seating_around_trial_room;
            $history->comment = $request->seating_around_trial_room_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->cloth_hanger != $data->cloth_hanger || ! empty($request->cloth_hanger_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Cloth Hanger Inside the Trial Room Available?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Cloth Hanger Inside the Trial Room Available?';
            $history->previous = $lastDocument->cloth_hanger;
            $history->current = $data->cloth_hanger;
            $history->comment = $request->cloth_hanger_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->any_remarks_on_the_trail_room != $data->any_remarks_on_the_trail_room || ! empty($request->any_remarks_on_the_trail_room_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks On The Trial Room ?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks On The Trial Room ?';
            $history->previous = $lastDocument->any_remarks_on_the_trail_room;
            $history->current = $data->any_remarks_on_the_trail_room;
            $history->comment = $request->any_remarks_on_the_trail_room_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }
        if ($lastDocument->comments_on_hte_overall_store != $data->comments_on_hte_overall_store || ! empty($request->comments_on_hte_overall_store_comment)) {
            $lastDocumentAuditTrail = FieldVisitAuditTrial::where('fieldvisit_id', $data->id)
                ->where('activity_type', 'Any Remarks / Comments Add on The Overall Store?')
                ->exists();
            $history = new FieldVisitAuditTrial();
            $history->fieldvisit_id = $id;
            $history->activity_type = 'Any Remarks / Comments Add on The Overall Store?';
            $history->previous = $lastDocument->comments_on_hte_overall_store;
            $history->current = $data->comments_on_hte_overall_store;
            $history->comment = $request->comments_on_hte_overall_store_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        //=========================================grid============================================
        $fieldvisit_id = $data->id;
        $newDataGridFiledVisit = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details1'])->firstOrCreate();
        $newDataGridFiledVisit->fv_id = $fieldvisit_id;
        $newDataGridFiledVisit->identifier = 'details1';
        $newDataGridFiledVisit->data = $request->details1;
        $newDataGridFiledVisit->save();

        $fieldvisit_id = $data->id;
        $newDataGridFiledVisit = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details2'])->firstOrCreate();
        $newDataGridFiledVisit->fv_id = $fieldvisit_id;
        $newDataGridFiledVisit->identifier = 'details2';
        $newDataGridFiledVisit->data = $request->details2;
        $newDataGridFiledVisit->save();

        //=========================================================================================

        toastr()->success('Record is Updated Successfully');

        return back();
    }

    public function sendstage(Request $request, $id)
    {
        try {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $data = FieldVisit::find($id);
                // dd($data);
                $lastDocument = FieldVisit::find($id);

                if ($data->stage == 1) {

                    $data->stage = '2';
                    $data->status = 'Pending Review';
                    $data->submit_by = Auth::user()->name;
                    $data->submit_on = Carbon::now()->format('d-M-Y');
                    $data->submit_comment = $request->comment;

                    // $history = new dataAuditTrail();
                    // $history->data_id = $id;
                    // $history->activity_type = 'Activity Log';
                    // $history->previous = "";
                    // $history->action='Submit';
                    // $history->current = $data->submit_by;
                    // $history->comment = $request->comment;
                    // $history->user_id = Auth::user()->id;
                    // $history->user_name = Auth::user()->name;
                    // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    // $history->origin_state = $lastDocument->status;
                    // $history->change_to =   "HOD Review";
                    // $history->change_from = $lastDocument->status;
                    // $history->stage = 'Plan Proposed';
                    // $history->save();

                    // $list = Helpers::getHodUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $data->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {

                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $data],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }

                    // $list = Helpers::getHeadoperationsUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $data->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {

                    //             Mail::send(
                    //                 'mail.Categorymail',
                    //                 ['data' => $data],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Activity Performed By " . Auth::user()->name);
                    //                 }
                    //             );
                    //         }
                    //     }
                    // }
                    // dd($data);
                    $data->update();

                    return back();
                }
                if ($data->stage == 2) {
                    $data->stage = '3';
                    $data->status = 'Close Done';
                    $data->pending_review_by = Auth::user()->name;
                    $data->pending_review_on = Carbon::now()->format('d-M-Y');
                    $data->pending_review_comment = $request->comment;

                    // $history = new dataAuditTrail();
                    // $history->data_id = $id;
                    // $history->activity_type = 'Activity Log';
                    // $history->previous = "";
                    // $history->current = $data->HOD_Review_Complete_By;
                    // $history->comment = $request->comment;
                    // $history->action= 'HOD Review Complete';
                    // $history->user_id = Auth::user()->id;
                    // $history->user_name = Auth::user()->name;
                    // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    // $history->origin_state = $lastDocument->status;
                    // $history->change_to =   "QA Initial Review";
                    // $history->change_from = $lastDocument->status;
                    // $history->stage = 'Plan Approved';
                    // $history->save();

                    // dd($history->action);
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $data->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $data],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }

                    $data->update();
                    toastr()->success('Document Sent');

                    return back();
                }

            } else {
                toastr()->error('E-signature Not match');

                return back();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function moreinforeject(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            // return $request;
            $data = FieldVisit::find($id);
            $lastDocument = FieldVisit::find($id);
            $list = Helpers::getInitiatorUserList();

            if ($data->stage == 2) {

                $data->stage = '1';
                $data->status = 'Opened';
                $data->review_completed_more_info_by = Auth::user()->name;
                $data->review_completed_more_info_on = Carbon::now()->format('d-M-Y');
                $data->review_completed_more_info_comment = $request->comment;

                $data->update();
                // $history = new dataHistory();
                // $history->type = "data";
                // $history->doc_id = $id;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->stage_id = $data->stage;
                // $history->status = "Opened";
                // foreach ($list as $u) {
                //     if ($u->q_m_s_divisions_id == $data->division_id) {
                //         $email = Helpers::getInitiatorEmail($u->user_id);
                //         if ($email !== null) {

                //             try {
                //                 Mail::send(
                //                     'mail.view-mail',
                //                     ['data' => $data],
                //                     function ($message) use ($email) {
                //                         $message->to($email)
                //                             ->subject("Activity Performed By " . Auth::user()->name);
                //                     }
                //                 );
                //             } catch (\Exception $e) {
                //                 //log error
                //             }
                //         }
                //     }
                // }
                // $history->save();

                toastr()->success('Document Sent');

                return back();
            }

        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    public function closecancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            // return $request;
            $data = FieldVisit::find($id);
            $lastDocument = FieldVisit::find($id);
            $list = Helpers::getInitiatorUserList();

            if ($data->stage == 1) {

                $data->stage = '0';
                $data->status = 'Opened';
                $data->close_cancel_by = Auth::user()->name;
                $data->close_cancel_on = Carbon::now()->format('d-M-Y');
                $data->close_cancel_comment = $request->comment;

                $data->update();
                // $history = new dataHistory();
                // $history->type = "data";
                // $history->doc_id = $id;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->stage_id = $data->stage;
                // $history->status = "Opened";
                // foreach ($list as $u) {
                //     if ($u->q_m_s_divisions_id == $data->division_id) {
                //         $email = Helpers::getInitiatorEmail($u->user_id);
                //         if ($email !== null) {

                //             try {
                //                 Mail::send(
                //                     'mail.view-mail',
                //                     ['data' => $data],
                //                     function ($message) use ($email) {
                //                         $message->to($email)
                //                             ->subject("Activity Performed By " . Auth::user()->name);
                //                     }
                //                 );
                //             } catch (\Exception $e) {
                //                 //log error
                //             }
                //         }
                //     }
                // }
                // $history->save();

                toastr()->success('Document Sent');

                return back();
            }

        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    public function FieldVisitAuditTrial($id)
    {
        $audit = FieldVisitAuditTrial::where('FieldVisit_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = FieldVisit::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.field-visit.field_visit_auditTrail', compact('audit', 'document', 'today'));
    }

    public function singleReports(Request $request, $id)
    {
        $data = FieldVisit::find($id);
        $grid_Data = FieldVisitGrid::where(['fv_id' => $id, 'identifier' => 'details1'])->first();
        $grid_Data2 = FieldVisitGrid::where(['fv_id' => $id, 'identifier' => 'details2'])->first();
        if (! empty($data)) {
            $data->data = FieldVisitGrid::where('fv_id', $id)->where('identifier', 'details1')->first();
            // $data->Instruments_Details = ErrataGrid::where('e_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = Erratagrid::where('e_id', $id)->where('type', "Material_Details")->first();
            // dd($data->all());
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.field-visit.field_visit_single_report', compact('data', 'grid_Data', 'grid_Data2'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);

            return $pdf->stream('errata'.$id.'.pdf');
        }
    }

    public function userCount()
    {
        $data = DB::table('field_visits')->pluck('save_data')->toArray();

        return response()->json(['data' => $data]);
    }

    // public function fetchData(Request $request){
    //     $data = FieldVisit::select('brand_name', 'field_visitor')->get();

    // return response()->json($data);
    // }

    public function brandVisitorData()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $brandData = [];
                $month = Carbon::now()->subMonths($i);

                // foreach ($brandName as $brandName)
                // {
                $brandNames = FieldVisit::where('brand_name', '!=', null)
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $visitor = FieldVisit::where('field_visitor', '!=', null)
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $brandData['month'] = $month->format('M');
                $brandData['brandName'] = $brandNames;
                $brandData['visitor'] = $visitor;

                array_push($data, $brandData);
                // }

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }
}
