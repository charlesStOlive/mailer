<?php namespace Waka\Mailer\Models;

use BackendAuth;
use Mjml\Client as MjmlClient;
use Model;

/**
 * WakaMail Model
 */
class WakaMail extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sortable;
    //
    use \Waka\Informer\Classes\Traits\InformerTrait;

    use \October\Rain\Database\Traits\Sluggable;
    protected $slugs = ['slug' => 'name'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_mailer_wakamails';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'data_source_id' => 'required',
        'name' => 'required',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = ['scopes', 'images', 'model_functions'];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        //'data_source' => ['Waka\Utils\Models\DataSource'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'informs' => ['Waka\Informer\Models\Inform', 'name' => 'informeable'],
    ];
    public $attachOne = [];
    public $attachMany = [];

    public function afterCreate()
    {
        if (BackendAuth::getUser()) {
        }

    }
    public function beforeSave()
    {
        if ($this->is_mjml && $this->mjml) {
            //transformation du mjmm en html via api mailjet.
            $applicationId = env('MJML_API_ID');
            $secretKey = env('MJML_API_SECRET');
            $client = new MjmlClient($applicationId, $secretKey);
            $this->template = $client->render($this->mjml);
        }
        if (!$this->is_mjml && $this->template_htm) {
            //transformation du mjmm en html via api mailjet.
            $this->template = $this->template_htm;
        }

    }
    /**
     * LISTS
     */
    public function listDataSource()
    {
        return \Waka\Utils\Classes\DataSourceList::lists();
    }
}