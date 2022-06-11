<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'sales_rep_id',
        'company_id'
    ];

    // protected $casts = [
    //     'birth_date' => 'date',
    // ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }
    

    public function lastInteraction()
    {
        return $this->hasOne(Interaction::class, 'id', 'last_interaction_id');
    }

    public function scopeWithLastInteraction($query)
    {
        $query->addSubSelect('last_interaction_id', Interaction::select('id')
            ->whereRaw('customer_id = customers.id')
            ->latest()
        )->with('lastInteraction');
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where(function ($query) use ($term) {
                $query->where('first_name', 'like', '%'.$term.'%')
                   ->orWhere('last_name', 'like', '%'.$term.'%')
                   ->orWhereHas('company', function ($query) use ($term) {
                       $query->where('name', 'like', '%'.$term.'%');
                   });
            });
        }
    }

    public function scopeWhereFilters($query, array $filters)
    {
        $filters = collect($filters);

        $query->when($filters->get('search'), function ($query, $search) {
            $query->whereSearch($search);
        })->when($filters->get('filter') === 'birthday_this_week', function ($query, $filter) {
            $query->whereBirthdayThisWeek();
        });
    }

    public function scopeWhereBirthdayThisWeek($query)
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        $dates = collect(new \DatePeriod($start, new \DateInterval('P1D'), $end))->map(function ($date) {
            return $date->format('m-d');
        });
        
        $query->whereNotNull('birth_date');
        
        return $query->whereIn(DB::raw("DATE_FORMAT(birth_date, '%m-%d')"), $dates);
    }

    public function scopeVisibleTo($query, User $user)
    {
        if ($user->is_admin) {
            return $query;
        }

        return $query->where('sales_rep_id', $user->id);
    }

    public function scopeOrderByField($query, $field)
    {
        if ($field['order'] === 'name') {
            $query->orderByName($field['dir']);
        } elseif ($field['order'] === 'company') {            
            $query->orderByCompany($field['dir']);
        } elseif ($field['order'] === 'birthday') {
            $query->orderByBirthday($field['dir']);
        } elseif ($field['order'] === 'last_interaction') {
            $query->orderByLastInteractionDate($field['dir']);
        }
    }

    public function scopeOrderByName($query,$dir)
    {
        $query->orderBy('last_name',$dir)->orderBy('first_name',$dir);
    }

    public function scopeOrderByCompany($query,$dir)
    {
        $query->orderBySub(Company::select('name')->whereRaw('customers.company_id = companies.id'),$dir);
    }

    public function scopeOrderByBirthday($query,$dir)
    {
        $query->orderbyRaw("DATE_FORMAT(birth_date, '%m-%d') {$dir}");
    }

    public function scopeOrderByLastInteractionDate($query,$dir)
    {
        $query->orderBySub(Interaction::select('created_at')->whereRaw('customers.id = interactions.customer_id')->latest(),$dir);
    }
}
