<?php

namespace App\Http\Controllers;
use App\Models\FieldVisit;
use App\Models\RecordNumber;
use App\Models\FieldVisitGrid;
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

    public function index(){

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        return view('frontend.field-visit.field_visit_new',compact('record_number'));
    }

    public function store(Request $request){
        $data = new FieldVisit();
        $data->stage = "1";
        $data->status = "Opened";
        // $data->type = "Field Visit Survey";
        $data->save_data = 1;
        $data->record = ((RecordNumber::first()->value('counter')) + 1);
        $data->division_code = $request->division_code;
        $data->initiator = $request->initiator;
        $data->intiation_date = $request->intiation_date;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->brand_name = $request->brand_name;
        $data->field_visitor = $request->field_visitor;
        $data->region = $request->region;
        $data->exact_location = $request->exact_location;
        $data->exact_address = $request->exact_address;

        if (!empty($request->photos)) {
            $files = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $name = $request->name . 'photos' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $files[] = $name;
                }
            }
            $data->photos = json_encode($files);
        }


        $data->any_remarks_on_vm = $request->any_remarks_on_vm;
        $data->any_ramrks_on_the_branding = $request->any_ramrks_on_the_branding;
        $data->page_section = $request->page_section;
        // $data->photos = $request->photos;
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
        $data->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

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


        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));

    }

    public function show($id){
        $data = FieldVisit::find($id);
        $fieldvisit_id = $data->id;
        $grid_Data = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details1'])->first();
        $grid_Data2 = FieldVisitGrid::where(['fv_id' => $fieldvisit_id, 'identifier' => 'details2'])->first();
         return view('frontend.field-visit.field_visit_view',compact('data','grid_Data','grid_Data2'));
    }


    public function update(Request $request, $id){

        $data = FieldVisit::find($id);
// dd($data);
        $data->save_data++;
        $data->date = $request->date;
        $data->time = $request->time;
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


        toastr()->success("Record is Updated Successfully");
        return back();
    }

    public function sendstage(Request $request,$id){
        try {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $data = FieldVisit::find($id);
                // dd($data);
                $lastDocument = FieldVisit::find($id);

                if ($data->stage == 1) {

                    $data->stage = "2";
                    $data->status = "Pending Review";
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
                    $data->stage = "3";
                    $data->status = "Close Done";
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
                'message' => $th->getMessage()
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

                $data->stage = "1";
                $data->status = "Opened";
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

                $data->stage = "0";
                $data->status = "Opened";
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

    public function singleReports(Request $request, $id)
    {
        $data = FieldVisit::find($id);
        $grid_Data = FieldVisitGrid::where(['fv_id' => $id, 'identifier' => 'details1'])->first();
        $grid_Data2 = FieldVisitGrid::where(['fv_id' => $id, 'identifier' => 'details2'])->first();
        if (!empty($data)) {
            $data->data = FieldVisitGrid::where('fv_id', $id)->where('identifier', "details1")->first();
            // $data->Instruments_Details = ErrataGrid::where('e_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = Erratagrid::where('e_id', $id)->where('type', "Material_Details")->first();
            // dd($data->all());
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.field-visit.field_visit_single_report', compact('data', 'grid_Data','grid_Data2'))
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
            return $pdf->stream('errata' . $id . '.pdf');
        }
    }

    public function userCount() {
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

            for ($i = 5; $i >= 0; $i--)
            {
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
