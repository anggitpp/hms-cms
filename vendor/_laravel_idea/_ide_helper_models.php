<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUnusedAliasInspection */

namespace App\Models\Master {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\Master\_IH_Employee_C;
    use LaravelIdea\Helper\App\Models\Master\_IH_Employee_QB;
    use LaravelIdea\Helper\App\Models\Master\_IH_Hotel_C;
    use LaravelIdea\Helper\App\Models\Master\_IH_Hotel_QB;
    use LaravelIdea\Helper\App\Models\Master\_IH_RoomAdditional_C;
    use LaravelIdea\Helper\App\Models\Master\_IH_RoomAdditional_QB;
    use LaravelIdea\Helper\App\Models\Master\_IH_RoomPackage_C;
    use LaravelIdea\Helper\App\Models\Master\_IH_RoomPackage_QB;
    use LaravelIdea\Helper\App\Models\Master\_IH_RoomPrice_C;
    use LaravelIdea\Helper\App\Models\Master\_IH_RoomPrice_QB;
    use LaravelIdea\Helper\App\Models\Master\_IH_Room_C;
    use LaravelIdea\Helper\App\Models\Master\_IH_Room_QB;
    
    /**
     * @property int $id
     * @property int $hotel_id
     * @property string $name
     * @property string|null $employee_number
     * @property int|null $birth_place
     * @property Carbon|null $birth_date
     * @property string $gender
     * @property int|null $religion_id
     * @property string|null $phone_number
     * @property string|null $photo
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int $position_id
     * @method _IH_Employee_QB newModelQuery()
     * @method _IH_Employee_QB newQuery()
     * @method static _IH_Employee_QB query()
     * @method static _IH_Employee_C|Employee[] all()
     * @mixin _IH_Employee_QB
     */
    class Employee extends Model {}
    
    /**
     * @property int $id
     * @property string $name
     * @property string $code
     * @property int $type_id
     * @property string|null $address
     * @property int|null $province_id
     * @property int|null $city_id
     * @property string|null $postal_code
     * @property string|null $phone_number
     * @property string|null $email
     * @property string|null $photo
     * @property string|null $longitude
     * @property string|null $latitude
     * @property string|null $description
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method _IH_Hotel_QB newModelQuery()
     * @method _IH_Hotel_QB newQuery()
     * @method static _IH_Hotel_QB query()
     * @method static _IH_Hotel_C|Hotel[] all()
     * @mixin _IH_Hotel_QB
     */
    class Hotel extends Model {}
    
    /**
     * @property int $id
     * @property int $hotel_id
     * @property int $type_id
     * @property string $number
     * @property string|null $description
     * @property int $status_id
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string|null $inactive_reason
     * @method _IH_Room_QB newModelQuery()
     * @method _IH_Room_QB newQuery()
     * @method static _IH_Room_QB query()
     * @method static _IH_Room_C|Room[] all()
     * @mixin _IH_Room_QB
     */
    class Room extends Model {}
    
    /**
     * @property int $id
     * @property int $hotel_id
     * @property string $name
     * @property string $price
     * @property string|null $description
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method _IH_RoomAdditional_QB newModelQuery()
     * @method _IH_RoomAdditional_QB newQuery()
     * @method static _IH_RoomAdditional_QB query()
     * @method static _IH_RoomAdditional_C|RoomAdditional[] all()
     * @mixin _IH_RoomAdditional_QB
     */
    class RoomAdditional extends Model {}
    
    /**
     * @property int $id
     * @property int $hotel_id
     * @property string $name
     * @property string $price
     * @property string|null $description
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method _IH_RoomPackage_QB newModelQuery()
     * @method _IH_RoomPackage_QB newQuery()
     * @method static _IH_RoomPackage_QB query()
     * @method static _IH_RoomPackage_C|RoomPackage[] all()
     * @mixin _IH_RoomPackage_QB
     */
    class RoomPackage extends Model {}
    
    /**
     * @property int $id
     * @property int $hotel_id
     * @property int $type_id
     * @property string $price
     * @property string|null $description
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method _IH_RoomPrice_QB newModelQuery()
     * @method _IH_RoomPrice_QB newQuery()
     * @method static _IH_RoomPrice_QB query()
     * @method static _IH_RoomPrice_C|RoomPrice[] all()
     * @mixin _IH_RoomPrice_QB
     */
    class RoomPrice extends Model {}
}

namespace App\Models\Setting {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\MorphToMany;
    use Illuminate\Notifications\DatabaseNotification;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Category_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Category_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_GroupModul_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_GroupModul_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Group_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Group_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Master_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Master_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_MenuAccess_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_MenuAccess_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Menu_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Menu_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Modul_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Modul_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Parameter_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Parameter_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_SubModul_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_SubModul_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_UserAccess_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_UserAccess_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_User_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_User_QB;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_C;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_QB;
    
    /**
     * @property Category $parent
     * @method BelongsTo|_IH_Category_QB parent()
     * @method _IH_Category_QB newModelQuery()
     * @method _IH_Category_QB newQuery()
     * @method static _IH_Category_QB query()
     * @method static _IH_Category_C|Category[] all()
     * @mixin _IH_Category_QB
     */
    class Category extends Model {}
    
    /**
     * @method _IH_Group_QB newModelQuery()
     * @method _IH_Group_QB newQuery()
     * @method static _IH_Group_QB query()
     * @method static _IH_Group_C|Group[] all()
     * @mixin _IH_Group_QB
     */
    class Group extends Model {}
    
    /**
     * @method _IH_GroupModul_QB newModelQuery()
     * @method _IH_GroupModul_QB newQuery()
     * @method static _IH_GroupModul_QB query()
     * @method static _IH_GroupModul_C|GroupModul[] all()
     * @mixin _IH_GroupModul_QB
     */
    class GroupModul extends Model {}
    
    /**
     * @method _IH_Master_QB newModelQuery()
     * @method _IH_Master_QB newQuery()
     * @method static _IH_Master_QB query()
     * @method static _IH_Master_C|Master[] all()
     * @mixin _IH_Master_QB
     */
    class Master extends Model {}
    
    /**
     * @property string|null $full_screen
     * @property _IH_Menu_C|Menu[] $menu
     * @property-read int $menu_count
     * @method HasMany|_IH_Menu_QB menu()
     * @property _IH_MenuAccess_C|MenuAccess[] $menuAccess
     * @property-read int $menu_access_count
     * @method HasMany|_IH_MenuAccess_QB menuAccess()
     * @property Modul $modul
     * @method BelongsTo|_IH_Modul_QB modul()
     * @method _IH_Menu_QB newModelQuery()
     * @method _IH_Menu_QB newQuery()
     * @method static _IH_Menu_QB query()
     * @method static _IH_Menu_C|Menu[] all()
     * @mixin _IH_Menu_QB
     */
    class Menu extends Model {}
    
    /**
     * @property Menu $menu
     * @method BelongsTo|_IH_Menu_QB menu()
     * @method _IH_MenuAccess_QB newModelQuery()
     * @method _IH_MenuAccess_QB newQuery()
     * @method static _IH_MenuAccess_QB query()
     * @method static _IH_MenuAccess_C|MenuAccess[] all()
     * @mixin _IH_MenuAccess_QB
     */
    class MenuAccess extends Model {}
    
    /**
     * @property _IH_Menu_C|Menu[] $menu
     * @property-read int $menu_count
     * @method HasMany|_IH_Menu_QB menu()
     * @property _IH_SubModul_C|SubModul[] $submodul
     * @property-read int $submodul_count
     * @method HasMany|_IH_SubModul_QB submodul()
     * @method _IH_Modul_QB newModelQuery()
     * @method _IH_Modul_QB newQuery()
     * @method static _IH_Modul_QB query()
     * @method static _IH_Modul_C|Modul[] all()
     * @mixin _IH_Modul_QB
     */
    class Modul extends Model {}
    
    /**
     * @method _IH_Parameter_QB newModelQuery()
     * @method _IH_Parameter_QB newQuery()
     * @method static _IH_Parameter_QB query()
     * @method static _IH_Parameter_C|Parameter[] all()
     * @mixin _IH_Parameter_QB
     */
    class Parameter extends Model {}
    
    /**
     * @property _IH_Menu_C|Menu[] $menu
     * @property-read int $menu_count
     * @method HasMany|_IH_Menu_QB menu()
     * @property Modul $modul
     * @method BelongsTo|_IH_Modul_QB modul()
     * @method _IH_SubModul_QB newModelQuery()
     * @method _IH_SubModul_QB newQuery()
     * @method static _IH_SubModul_QB query()
     * @method static _IH_SubModul_C|SubModul[] all()
     * @mixin _IH_SubModul_QB
     */
    class SubModul extends Model {}
    
    /**
     * @property Group $group
     * @method BelongsTo|_IH_Group_QB group()
     * @property _IH_DatabaseNotification_C|DatabaseNotification[] $notifications
     * @property-read int $notifications_count
     * @method MorphToMany|_IH_DatabaseNotification_QB notifications()
     * @method _IH_User_QB newModelQuery()
     * @method _IH_User_QB newQuery()
     * @method static _IH_User_QB query()
     * @method static _IH_User_C|User[] all()
     * @mixin _IH_User_QB
     */
    class User extends Model {}
    
    /**
     * @property Menu $menu
     * @method BelongsTo|_IH_Menu_QB menu()
     * @method _IH_UserAccess_QB newModelQuery()
     * @method _IH_UserAccess_QB newQuery()
     * @method static _IH_UserAccess_QB query()
     * @method static _IH_UserAccess_C|UserAccess[] all()
     * @mixin _IH_UserAccess_QB
     */
    class UserAccess extends Model {}
}

namespace App\Models\Transaction {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\Transaction\_IH_HotelOrder_C;
    use LaravelIdea\Helper\App\Models\Transaction\_IH_HotelOrder_QB;
    
    /**
     * @property int $id
     * @property int $hotel_id
     * @property string $name
     * @property string|null $identity_number
     * @property string|null $address
     * @property int|null $province_id
     * @property int|null $city_id
     * @property string|null $postal_code
     * @property string|null $email
     * @property string|null $phone_number
     * @property string|null $company_name
     * @property Carbon $arrival_date
     * @property Carbon $departure_date
     * @property int $number_of_nights
     * @property int $number_of_adults
     * @property int|null $package_id
     * @property string|null $rooms
     * @property int|null $extra_bed
     * @property string|null $price
     * @property int|null $discount
     * @property string|null $discount_price
     * @property string|null $fix_price
     * @property string|null $note
     * @property string $status
     * @property string $payment_method
     * @property string $payment_detail
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int|null $package_total
     * @property string|null $package_price
     * @property string|null $extra_bed_price
     * @property string|null $company_emergency_name
     * @property string|null $company_phone
     * @property string|null $company_accomodation
     * @method _IH_HotelOrder_QB newModelQuery()
     * @method _IH_HotelOrder_QB newQuery()
     * @method static _IH_HotelOrder_QB query()
     * @method static _IH_HotelOrder_C|HotelOrder[] all()
     * @mixin _IH_HotelOrder_QB
     */
    class HotelOrder extends Model {}
}

namespace Illuminate\Notifications {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_C;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_QB;
    
    /**
     * @property Model $notifiable
     * @method MorphTo notifiable()
     * @method _IH_DatabaseNotification_QB newModelQuery()
     * @method _IH_DatabaseNotification_QB newQuery()
     * @method static _IH_DatabaseNotification_QB query()
     * @method static _IH_DatabaseNotification_C|DatabaseNotification[] all()
     * @mixin _IH_DatabaseNotification_QB
     */
    class DatabaseNotification extends Model {}
}

namespace Laravel\Sanctum {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use LaravelIdea\Helper\Laravel\Sanctum\_IH_PersonalAccessToken_C;
    use LaravelIdea\Helper\Laravel\Sanctum\_IH_PersonalAccessToken_QB;
    
    /**
     * @property Model $tokenable
     * @method MorphTo tokenable()
     * @method _IH_PersonalAccessToken_QB newModelQuery()
     * @method _IH_PersonalAccessToken_QB newQuery()
     * @method static _IH_PersonalAccessToken_QB query()
     * @method static _IH_PersonalAccessToken_C|PersonalAccessToken[] all()
     * @mixin _IH_PersonalAccessToken_QB
     */
    class PersonalAccessToken extends Model {}
}