<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Setting;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $order_prefix_data=Setting::where('name','inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';

        return [

            'id' => $this->id,
            'user_id'=>$this->user_id,
            'delivery_status'=>$this->delivery_status,
            'payment_status'=>$this->payment_status,
            'order_code' => $order_prefix . optional($this->orderGroup)->order_code,
            'sub_total_amount'=>optional($this->orderGroup)->sub_total_amount,
            'total_tax_amount'=>optional($this->orderGroup)->total_tax_amount,
            'logistic_charge'=>optional($this->orderGroup)->total_shipping_cost,
            'total_amount'=>optional($this->orderGroup)->grand_total_amount,
            'payment_method'=>optional($this->orderGroup)->payment_method,
            'order_date'=>$this->created_at,
            'logistic_name'=>$this->logistic_name,
            'expected_delivery_date' => optional($this->logistic)->standard_delivery_time? $this->calculateExpectedDeliveryDate(): null,
            'delivery_days'=>optional($this->logistic)->standard_delivery_time,
            'delivery_time'=>optional($this->logistic)->standard_delivery_time,
            'user_name' =>optional(optional($this->orderGroup)->shippingAddress)->first_name.' '.optional(optional($this->orderGroup)->shippingAddress)->last_name,
            'address_line_1'=>optional(optional($this->orderGroup)->shippingAddress)->address_line_1,
            'address_line_2'=>optional(optional($this->orderGroup)->shippingAddress)->address_line_2,
            'phone_no'=>optional($this->orderGroup)->phone_no,
            'alternative_phone_no'=>optional($this->orderGroup)->alternative_phone_no,    
            'city' => $this->orderGroup?->shippingAddress?->city_data?->name ?? null,           
            'state' => $this->orderGroup?->shippingAddress?->state_data?->name ?? null,
            'country' => $this->orderGroup?->shippingAddress?->country_data?->name ?? null,
            'postal_code' => $this->orderGroup?->shippingAddress?->postal_code ?? null,      
            'product_details'=>OrderItemResource::collection($this->orderItems),
          
        ];
      }

      private function calculateExpectedDeliveryDate()
      {
          $orderDate = Carbon::parse($this->created_at);
          $deliveryTimeInDays = intval($this->logistic->standard_delivery_time);
       
          return $orderDate->addDays($deliveryTimeInDays);
      
          return $expectedDeliveryDate;
      }
    }

