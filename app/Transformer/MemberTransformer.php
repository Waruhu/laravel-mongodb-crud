<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use Leaque\Fractal;
use app\Member;

class MemberTransformer extends TransformerAbstract
{
	public function transform(Member $member)
	{
	    return [
	        'id'           => $member['_id'],
            'first_name'   => $member['first_name'],
            'last_name'    => $member['last_name'],
            'sex'          => $member['gender'],
            'address'      => $member['address'],
            'status'       => $member['status'],
	    ];
	}
}
