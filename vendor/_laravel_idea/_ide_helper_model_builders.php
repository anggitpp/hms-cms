<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUnusedAliasInspection */

namespace LaravelIdea\Helper {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\ConnectionInterface;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Query\Expression;
    
    /**
     * @see \Illuminate\Database\Query\Builder::whereIn
     * @method $this whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::orWhereNotIn
     * @method $this orWhereNotIn(string $column, $values)
     * @see \Illuminate\Database\Query\Builder::selectRaw
     * @method $this selectRaw(string $expression, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::insertOrIgnore
     * @method int insertOrIgnore(array $values)
     * @see \Illuminate\Database\Query\Builder::unionAll
     * @method $this unionAll(\Closure|\Illuminate\Database\Query\Builder $query)
     * @see \Illuminate\Database\Query\Builder::orWhereNull
     * @method $this orWhereNull(array|string $column)
     * @see \Illuminate\Database\Query\Builder::joinWhere
     * @method $this joinWhere(string $table, \Closure|string $first, string $operator, string $second, string $type = 'inner')
     * @see \Illuminate\Database\Query\Builder::orWhereJsonContains
     * @method $this orWhereJsonContains(string $column, $value)
     * @see \Illuminate\Database\Query\Builder::orderBy
     * @method $this orderBy(\Closure|Builder|\Illuminate\Database\Query\Builder|Expression|string $column, string $direction = 'asc')
     * @see \Illuminate\Database\Query\Builder::raw
     * @method Expression raw($value)
     * @see \Illuminate\Database\Concerns\BuildsQueries::each
     * @method $this each(callable $callback, int $count = 1000)
     * @see \Illuminate\Database\Query\Builder::setBindings
     * @method $this setBindings(array $bindings, string $type = 'where')
     * @see \Illuminate\Database\Query\Builder::orWhereJsonLength
     * @method $this orWhereJsonLength(string $column, $operator, $value = null)
     * @see \Illuminate\Database\Query\Builder::whereRowValues
     * @method $this whereRowValues(array $columns, string $operator, array $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereNotExists
     * @method $this orWhereNotExists(\Closure $callback)
     * @see \Illuminate\Database\Query\Builder::orWhereIntegerInRaw
     * @method $this orWhereIntegerInRaw(string $column, array|Arrayable $values)
     * @see \Illuminate\Database\Query\Builder::newQuery
     * @method $this newQuery()
     * @see \Illuminate\Database\Query\Builder::rightJoinSub
     * @method $this rightJoinSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::crossJoin
     * @method $this crossJoin(string $table, \Closure|null|string $first = null, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::average
     * @method mixed average(string $column)
     * @see \Illuminate\Database\Query\Builder::existsOr
     * @method $this existsOr(\Closure $callback)
     * @see \Illuminate\Database\Query\Builder::sum
     * @method int|mixed sum(string $column)
     * @see \Illuminate\Database\Query\Builder::havingRaw
     * @method $this havingRaw(string $sql, array $bindings = [], string $boolean = 'and')
     * @see \Illuminate\Database\Concerns\BuildsQueries::chunkMap
     * @method $this chunkMap(callable $callback, int $count = 1000)
     * @see \Illuminate\Database\Query\Builder::getRawBindings
     * @method $this getRawBindings()
     * @see \Illuminate\Database\Query\Builder::orWhereColumn
     * @method $this orWhereColumn(array|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::min
     * @method mixed min(string $column)
     * @see \Illuminate\Support\Traits\Conditionable::unless
     * @method $this unless($value, callable $callback, callable|null $default = null)
     * @see \Illuminate\Database\Query\Builder::whereNotIn
     * @method $this whereNotIn(string $column, $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereTime
     * @method $this whereTime(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::insertUsing
     * @method int insertUsing(array $columns, \Closure|\Illuminate\Database\Query\Builder|string $query)
     * @see \Illuminate\Database\Concerns\BuildsQueries::lazyById
     * @method $this lazyById($chunkSize = 1000, null|string $column = null, null|string $alias = null)
     * @see \Illuminate\Database\Query\Builder::rightJoinWhere
     * @method $this rightJoinWhere(string $table, \Closure|string $first, string $operator, string $second)
     * @see \Illuminate\Database\Query\Builder::union
     * @method $this union(\Closure|\Illuminate\Database\Query\Builder $query, bool $all = false)
     * @see \Illuminate\Database\Query\Builder::groupBy
     * @method $this groupBy(...$groups)
     * @see \Illuminate\Database\Query\Builder::orWhereDay
     * @method $this orWhereDay(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::joinSub
     * @method $this joinSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as, \Closure|string $first, null|string $operator = null, null|string $second = null, string $type = 'inner', bool $where = false)
     * @see \Illuminate\Database\Query\Builder::selectSub
     * @method $this selectSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as)
     * @see \Illuminate\Database\Query\Builder::dd
     * @method void dd()
     * @see \Illuminate\Database\Query\Builder::whereNull
     * @method $this whereNull(array|string $columns, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::prepareValueAndOperator
     * @method $this prepareValueAndOperator(string $value, string $operator, bool $useDefault = false)
     * @see \Illuminate\Database\Query\Builder::whereIntegerNotInRaw
     * @method $this whereIntegerNotInRaw(string $column, array|Arrayable $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereRaw
     * @method $this orWhereRaw(string $sql, $bindings = [])
     * @see \Illuminate\Database\Query\Builder::whereJsonContains
     * @method $this whereJsonContains(string $column, $value, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::orWhereBetweenColumns
     * @method $this orWhereBetweenColumns(string $column, array $values)
     * @see \Illuminate\Database\Query\Builder::mergeWheres
     * @method $this mergeWheres(array $wheres, array $bindings)
     * @see \Illuminate\Database\Query\Builder::applyBeforeQueryCallbacks
     * @method $this applyBeforeQueryCallbacks()
     * @see \Illuminate\Database\Query\Builder::sharedLock
     * @method $this sharedLock()
     * @see \Illuminate\Database\Query\Builder::orderByRaw
     * @method $this orderByRaw(string $sql, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::doesntExist
     * @method bool doesntExist()
     * @see \Illuminate\Database\Query\Builder::orWhereMonth
     * @method $this orWhereMonth(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::whereNotNull
     * @method $this whereNotNull(array|string $columns, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::count
     * @method int count(string $columns = '*')
     * @see \Illuminate\Database\Query\Builder::orWhereNotBetween
     * @method $this orWhereNotBetween(string $column, array $values)
     * @see \Illuminate\Database\Query\Builder::fromRaw
     * @method $this fromRaw(string $expression, $bindings = [])
     * @see \Illuminate\Support\Traits\Macroable::mixin
     * @method $this mixin(object $mixin, bool $replace = true)
     * @see \Illuminate\Database\Query\Builder::take
     * @method $this take(int $value)
     * @see \Illuminate\Database\Query\Builder::orWhereNotBetweenColumns
     * @method $this orWhereNotBetweenColumns(string $column, array $values)
     * @see \Illuminate\Database\Query\Builder::updateOrInsert
     * @method $this updateOrInsert(array $attributes, array $values = [])
     * @see \Illuminate\Database\Query\Builder::cloneWithout
     * @method $this cloneWithout(array $properties)
     * @see \Illuminate\Database\Query\Builder::whereBetweenColumns
     * @method $this whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::fromSub
     * @method $this fromSub(\Closure|\Illuminate\Database\Query\Builder|string $query, string $as)
     * @see \Illuminate\Database\Query\Builder::cleanBindings
     * @method $this cleanBindings(array $bindings)
     * @see \Illuminate\Database\Query\Builder::orWhereDate
     * @method $this orWhereDate(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::avg
     * @method mixed avg(string $column)
     * @see \Illuminate\Database\Query\Builder::addBinding
     * @method $this addBinding($value, string $type = 'where')
     * @see \Illuminate\Database\Query\Builder::getGrammar
     * @method $this getGrammar()
     * @see \Illuminate\Database\Query\Builder::lockForUpdate
     * @method $this lockForUpdate()
     * @see \Illuminate\Database\Concerns\BuildsQueries::eachById
     * @method $this eachById(callable $callback, int $count = 1000, null|string $column = null, null|string $alias = null)
     * @see \Illuminate\Database\Query\Builder::cloneWithoutBindings
     * @method $this cloneWithoutBindings(array $except)
     * @see \Illuminate\Database\Query\Builder::orHavingRaw
     * @method $this orHavingRaw(string $sql, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::forPageBeforeId
     * @method $this forPageBeforeId(int $perPage = 15, int|null $lastId = 0, string $column = 'id')
     * @see \Illuminate\Database\Query\Builder::orWhereBetween
     * @method $this orWhereBetween(string $column, array $values)
     * @see \Illuminate\Database\Concerns\ExplainsQueries::explain
     * @method $this explain()
     * @see \Illuminate\Database\Query\Builder::select
     * @method $this select(array|mixed $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::addSelect
     * @method $this addSelect(array|mixed $column)
     * @see \Illuminate\Support\Traits\Conditionable::when
     * @method $this when($value, callable $callback, callable|null $default = null)
     * @see \Illuminate\Database\Query\Builder::whereJsonLength
     * @method $this whereJsonLength(string $column, $operator, $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereExists
     * @method $this orWhereExists(\Closure $callback, bool $not = false)
     * @see \Illuminate\Database\Query\Builder::beforeQuery
     * @method $this beforeQuery(callable $callback)
     * @see \Illuminate\Database\Query\Builder::truncate
     * @method $this truncate()
     * @see \Illuminate\Database\Query\Builder::lock
     * @method $this lock(bool|string $value = true)
     * @see \Illuminate\Database\Query\Builder::join
     * @method $this join(string $table, \Closure|string $first, null|string $operator = null, null|string $second = null, string $type = 'inner', bool $where = false)
     * @see \Illuminate\Database\Query\Builder::whereMonth
     * @method $this whereMonth(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::having
     * @method $this having(string $column, null|string $operator = null, null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereNested
     * @method $this whereNested(\Closure $callback, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::orWhereRowValues
     * @method $this orWhereRowValues(array $columns, string $operator, array $values)
     * @see \Illuminate\Database\Query\Builder::useWritePdo
     * @method $this useWritePdo()
     * @see \Illuminate\Database\Query\Builder::orWhereIn
     * @method $this orWhereIn(string $column, $values)
     * @see \Illuminate\Database\Query\Builder::orderByDesc
     * @method $this orderByDesc(\Closure|Builder|\Illuminate\Database\Query\Builder|Expression|string $column)
     * @see \Illuminate\Database\Query\Builder::orWhereNotNull
     * @method $this orWhereNotNull(string $column)
     * @see \Illuminate\Database\Query\Builder::getProcessor
     * @method $this getProcessor()
     * @see \Illuminate\Database\Concerns\BuildsQueries::lazy
     * @method $this lazy(int $chunkSize = 1000)
     * @see \Illuminate\Database\Query\Builder::skip
     * @method $this skip(int $value)
     * @see \Illuminate\Database\Query\Builder::leftJoinWhere
     * @method $this leftJoinWhere(string $table, \Closure|string $first, string $operator, string $second)
     * @see \Illuminate\Database\Query\Builder::doesntExistOr
     * @method $this doesntExistOr(\Closure $callback)
     * @see \Illuminate\Database\Query\Builder::whereNotExists
     * @method $this whereNotExists(\Closure $callback, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereIntegerInRaw
     * @method $this whereIntegerInRaw(string $column, array|Arrayable $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::whereDay
     * @method $this whereDay(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::forNestedWhere
     * @method $this forNestedWhere()
     * @see \Illuminate\Database\Query\Builder::max
     * @method mixed max(string $column)
     * @see \Illuminate\Database\Query\Builder::whereExists
     * @method $this whereExists(\Closure $callback, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::inRandomOrder
     * @method $this inRandomOrder(string $seed = '')
     * @see \Illuminate\Database\Query\Builder::havingBetween
     * @method $this havingBetween(string $column, array $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Query\Builder::orWhereYear
     * @method $this orWhereYear(string $column, string $operator, \DateTimeInterface|int|null|string $value = null)
     * @see \Illuminate\Database\Concerns\BuildsQueries::chunkById
     * @method $this chunkById(int $count, callable $callback, null|string $column = null, null|string $alias = null)
     * @see \Illuminate\Database\Query\Builder::whereDate
     * @method $this whereDate(string $column, string $operator, \DateTimeInterface|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::whereJsonDoesntContain
     * @method $this whereJsonDoesntContain(string $column, $value, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::forPageAfterId
     * @method $this forPageAfterId(int $perPage = 15, int|null $lastId = 0, string $column = 'id')
     * @see \Illuminate\Database\Query\Builder::forPage
     * @method $this forPage(int $page, int $perPage = 15)
     * @see \Illuminate\Database\Query\Builder::exists
     * @method bool exists()
     * @see \Illuminate\Support\Traits\Macroable::macroCall
     * @method $this macroCall(string $method, array $parameters)
     * @see \Illuminate\Database\Concerns\BuildsQueries::first
     * @method $this first(array|string $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::whereColumn
     * @method $this whereColumn(array|string $first, null|string $operator = null, null|string $second = null, null|string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::numericAggregate
     * @method $this numericAggregate(string $function, array $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::whereNotBetween
     * @method $this whereNotBetween(string $column, array $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::getConnection
     * @method ConnectionInterface getConnection()
     * @see \Illuminate\Database\Query\Builder::mergeBindings
     * @method $this mergeBindings(\Illuminate\Database\Query\Builder $query)
     * @see \Illuminate\Database\Query\Builder::orWhereJsonDoesntContain
     * @method $this orWhereJsonDoesntContain(string $column, $value)
     * @see \Illuminate\Database\Query\Builder::leftJoinSub
     * @method $this leftJoinSub(\Closure|Builder|\Illuminate\Database\Query\Builder|string $query, string $as, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::crossJoinSub
     * @method $this crossJoinSub(\Closure|\Illuminate\Database\Query\Builder|string $query, string $as)
     * @see \Illuminate\Database\Query\Builder::limit
     * @method $this limit(int $value)
     * @see \Illuminate\Database\Query\Builder::from
     * @method $this from(\Closure|\Illuminate\Database\Query\Builder|string $table, null|string $as = null)
     * @see \Illuminate\Database\Query\Builder::whereNotBetweenColumns
     * @method $this whereNotBetweenColumns(string $column, array $values, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::insertGetId
     * @method int insertGetId(array $values, null|string $sequence = null)
     * @see \Illuminate\Database\Query\Builder::whereBetween
     * @method $this whereBetween(Expression|string $column, array $values, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Database\Concerns\BuildsQueries::tap
     * @method $this tap(callable $callback)
     * @see \Illuminate\Database\Query\Builder::offset
     * @method $this offset(int $value)
     * @see \Illuminate\Database\Query\Builder::addNestedWhereQuery
     * @method $this addNestedWhereQuery(\Illuminate\Database\Query\Builder $query, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::rightJoin
     * @method $this rightJoin(string $table, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::leftJoin
     * @method $this leftJoin(string $table, \Closure|string $first, null|string $operator = null, null|string $second = null)
     * @see \Illuminate\Database\Query\Builder::insert
     * @method bool insert(array $values)
     * @see \Illuminate\Database\Query\Builder::distinct
     * @method $this distinct()
     * @see \Illuminate\Database\Concerns\BuildsQueries::chunk
     * @method $this chunk(int $count, callable $callback)
     * @see \Illuminate\Database\Query\Builder::reorder
     * @method $this reorder(\Closure|\Illuminate\Database\Query\Builder|Expression|null|string $column = null, string $direction = 'asc')
     * @see \Illuminate\Database\Query\Builder::whereYear
     * @method $this whereYear(string $column, string $operator, \DateTimeInterface|int|null|string $value = null, string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::getCountForPagination
     * @method $this getCountForPagination(array $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::groupByRaw
     * @method $this groupByRaw(string $sql, array $bindings = [])
     * @see \Illuminate\Database\Query\Builder::orWhereIntegerNotInRaw
     * @method $this orWhereIntegerNotInRaw(string $column, array|Arrayable $values)
     * @see \Illuminate\Database\Query\Builder::aggregate
     * @method $this aggregate(string $function, array $columns = ['*'])
     * @see \Illuminate\Database\Query\Builder::dump
     * @method void dump()
     * @see \Illuminate\Database\Query\Builder::implode
     * @method $this implode(string $column, string $glue = '')
     * @see \Illuminate\Database\Query\Builder::addWhereExistsQuery
     * @method $this addWhereExistsQuery(\Illuminate\Database\Query\Builder $query, string $boolean = 'and', bool $not = false)
     * @see \Illuminate\Support\Traits\Macroable::macro
     * @method $this macro(string $name, callable|object $macro)
     * @see \Illuminate\Database\Query\Builder::whereRaw
     * @method $this whereRaw(string $sql, $bindings = [], string $boolean = 'and')
     * @see \Illuminate\Database\Query\Builder::toSql
     * @method string toSql()
     * @see \Illuminate\Database\Query\Builder::orHaving
     * @method $this orHaving(string $column, null|string $operator = null, null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::getBindings
     * @method array getBindings()
     * @see \Illuminate\Database\Query\Builder::orWhereTime
     * @method $this orWhereTime(string $column, string $operator, \DateTimeInterface|null|string $value = null)
     * @see \Illuminate\Database\Query\Builder::dynamicWhere
     * @method $this dynamicWhere(string $method, array $parameters)
     */
    class _BaseBuilder extends Builder {}
    
    /**
     * @method \Illuminate\Support\Collection mapSpread(callable $callback)
     * @method \Illuminate\Support\Collection mapWithKeys(callable $callback)
     * @method \Illuminate\Support\Collection zip(array $items)
     * @method \Illuminate\Support\Collection partition(callable|string $key, $operator = null, $value = null)
     * @method \Illuminate\Support\Collection mapInto(string $class)
     * @method \Illuminate\Support\Collection mapToGroups(callable $callback)
     * @method \Illuminate\Support\Collection map(callable $callback)
     * @method \Illuminate\Support\Collection groupBy(array|callable|string $groupBy, bool $preserveKeys = false)
     * @method \Illuminate\Support\Collection pluck(array|string $value, null|string $key = null)
     * @method \Illuminate\Support\Collection pad(int $size, $value)
     * @method \Illuminate\Support\Collection split(int $numberOfGroups)
     * @method \Illuminate\Support\Collection combine($values)
     * @method \Illuminate\Support\Collection countBy(callable|string $countBy = null)
     * @method \Illuminate\Support\Collection mapToDictionary(callable $callback)
     * @method \Illuminate\Support\Collection keys()
     * @method \Illuminate\Support\Collection transform(callable $callback)
     * @method \Illuminate\Support\Collection flatMap(callable $callback)
     * @method \Illuminate\Support\Collection collapse()
     */
    class _BaseCollection extends \Illuminate\Database\Eloquent\Collection {}
}

namespace LaravelIdea\Helper\App\Models\Master {

    use App\Models\Master\Employee;
    use App\Models\Master\Hotel;
    use App\Models\Master\Room;
    use App\Models\Master\RoomAdditional;
    use App\Models\Master\RoomPackage;
    use App\Models\Master\RoomPrice;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method Employee shift(int $count = 1)
     * @method Employee pop(int $count = 1)
     * @method Employee get($key, $default = null)
     * @method Employee pull($key, $default = null)
     * @method Employee first(callable $callback = null, $default = null)
     * @method Employee firstWhere(string $key, $operator = null, $value = null)
     * @method Employee find($key, $default = null)
     * @method Employee[] all()
     * @method Employee last(callable $callback = null, $default = null)
     */
    class _IH_Employee_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Employee[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Employee_QB whereId($value)
     * @method _IH_Employee_QB whereHotelId($value)
     * @method _IH_Employee_QB whereName($value)
     * @method _IH_Employee_QB whereEmployeeNumber($value)
     * @method _IH_Employee_QB whereBirthPlace($value)
     * @method _IH_Employee_QB whereBirthDate($value)
     * @method _IH_Employee_QB whereGender($value)
     * @method _IH_Employee_QB whereReligionId($value)
     * @method _IH_Employee_QB wherePhoneNumber($value)
     * @method _IH_Employee_QB wherePhoto($value)
     * @method _IH_Employee_QB whereStatus($value)
     * @method _IH_Employee_QB whereCreatedBy($value)
     * @method _IH_Employee_QB whereUpdatedBy($value)
     * @method _IH_Employee_QB whereCreatedAt($value)
     * @method _IH_Employee_QB whereUpdatedAt($value)
     * @method _IH_Employee_QB wherePositionId($value)
     * @method Employee baseSole(array|string $columns = ['*'])
     * @method Employee create(array $attributes = [])
     * @method _IH_Employee_C|Employee[] cursor()
     * @method Employee|null|_IH_Employee_C|Employee[] find($id, array $columns = ['*'])
     * @method _IH_Employee_C|Employee[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Employee|_IH_Employee_C|Employee[] findOrFail($id, array $columns = ['*'])
     * @method Employee|_IH_Employee_C|Employee[] findOrNew($id, array $columns = ['*'])
     * @method Employee first(array|string $columns = ['*'])
     * @method Employee firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Employee firstOrCreate(array $attributes = [], array $values = [])
     * @method Employee firstOrFail(array $columns = ['*'])
     * @method Employee firstOrNew(array $attributes = [], array $values = [])
     * @method Employee firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Employee forceCreate(array $attributes)
     * @method _IH_Employee_C|Employee[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Employee_C|Employee[] get(array|string $columns = ['*'])
     * @method Employee getModel()
     * @method Employee[] getModels(array|string $columns = ['*'])
     * @method _IH_Employee_C|Employee[] hydrate(array $items)
     * @method Employee make(array $attributes = [])
     * @method Employee newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Employee[]|_IH_Employee_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Employee[]|_IH_Employee_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Employee sole(array|string $columns = ['*'])
     * @method Employee updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Employee_QB extends _BaseBuilder {}
    
    /**
     * @method Hotel shift(int $count = 1)
     * @method Hotel pop(int $count = 1)
     * @method Hotel get($key, $default = null)
     * @method Hotel pull($key, $default = null)
     * @method Hotel first(callable $callback = null, $default = null)
     * @method Hotel firstWhere(string $key, $operator = null, $value = null)
     * @method Hotel find($key, $default = null)
     * @method Hotel[] all()
     * @method Hotel last(callable $callback = null, $default = null)
     */
    class _IH_Hotel_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Hotel[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Hotel_QB whereId($value)
     * @method _IH_Hotel_QB whereName($value)
     * @method _IH_Hotel_QB whereCode($value)
     * @method _IH_Hotel_QB whereTypeId($value)
     * @method _IH_Hotel_QB whereAddress($value)
     * @method _IH_Hotel_QB whereProvinceId($value)
     * @method _IH_Hotel_QB whereCityId($value)
     * @method _IH_Hotel_QB wherePostalCode($value)
     * @method _IH_Hotel_QB wherePhoneNumber($value)
     * @method _IH_Hotel_QB whereEmail($value)
     * @method _IH_Hotel_QB wherePhoto($value)
     * @method _IH_Hotel_QB whereLongitude($value)
     * @method _IH_Hotel_QB whereLatitude($value)
     * @method _IH_Hotel_QB whereDescription($value)
     * @method _IH_Hotel_QB whereStatus($value)
     * @method _IH_Hotel_QB whereCreatedBy($value)
     * @method _IH_Hotel_QB whereUpdatedBy($value)
     * @method _IH_Hotel_QB whereCreatedAt($value)
     * @method _IH_Hotel_QB whereUpdatedAt($value)
     * @method Hotel baseSole(array|string $columns = ['*'])
     * @method Hotel create(array $attributes = [])
     * @method _IH_Hotel_C|Hotel[] cursor()
     * @method Hotel|null|_IH_Hotel_C|Hotel[] find($id, array $columns = ['*'])
     * @method _IH_Hotel_C|Hotel[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Hotel|_IH_Hotel_C|Hotel[] findOrFail($id, array $columns = ['*'])
     * @method Hotel|_IH_Hotel_C|Hotel[] findOrNew($id, array $columns = ['*'])
     * @method Hotel first(array|string $columns = ['*'])
     * @method Hotel firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Hotel firstOrCreate(array $attributes = [], array $values = [])
     * @method Hotel firstOrFail(array $columns = ['*'])
     * @method Hotel firstOrNew(array $attributes = [], array $values = [])
     * @method Hotel firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Hotel forceCreate(array $attributes)
     * @method _IH_Hotel_C|Hotel[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Hotel_C|Hotel[] get(array|string $columns = ['*'])
     * @method Hotel getModel()
     * @method Hotel[] getModels(array|string $columns = ['*'])
     * @method _IH_Hotel_C|Hotel[] hydrate(array $items)
     * @method Hotel make(array $attributes = [])
     * @method Hotel newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Hotel[]|_IH_Hotel_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Hotel[]|_IH_Hotel_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Hotel sole(array|string $columns = ['*'])
     * @method Hotel updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Hotel_QB extends _BaseBuilder {}
    
    /**
     * @method RoomAdditional shift(int $count = 1)
     * @method RoomAdditional pop(int $count = 1)
     * @method RoomAdditional get($key, $default = null)
     * @method RoomAdditional pull($key, $default = null)
     * @method RoomAdditional first(callable $callback = null, $default = null)
     * @method RoomAdditional firstWhere(string $key, $operator = null, $value = null)
     * @method RoomAdditional find($key, $default = null)
     * @method RoomAdditional[] all()
     * @method RoomAdditional last(callable $callback = null, $default = null)
     */
    class _IH_RoomAdditional_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RoomAdditional[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_RoomAdditional_QB whereId($value)
     * @method _IH_RoomAdditional_QB whereHotelId($value)
     * @method _IH_RoomAdditional_QB whereName($value)
     * @method _IH_RoomAdditional_QB wherePrice($value)
     * @method _IH_RoomAdditional_QB whereDescription($value)
     * @method _IH_RoomAdditional_QB whereStatus($value)
     * @method _IH_RoomAdditional_QB whereCreatedBy($value)
     * @method _IH_RoomAdditional_QB whereUpdatedBy($value)
     * @method _IH_RoomAdditional_QB whereCreatedAt($value)
     * @method _IH_RoomAdditional_QB whereUpdatedAt($value)
     * @method RoomAdditional baseSole(array|string $columns = ['*'])
     * @method RoomAdditional create(array $attributes = [])
     * @method _IH_RoomAdditional_C|RoomAdditional[] cursor()
     * @method RoomAdditional|null|_IH_RoomAdditional_C|RoomAdditional[] find($id, array $columns = ['*'])
     * @method _IH_RoomAdditional_C|RoomAdditional[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RoomAdditional|_IH_RoomAdditional_C|RoomAdditional[] findOrFail($id, array $columns = ['*'])
     * @method RoomAdditional|_IH_RoomAdditional_C|RoomAdditional[] findOrNew($id, array $columns = ['*'])
     * @method RoomAdditional first(array|string $columns = ['*'])
     * @method RoomAdditional firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RoomAdditional firstOrCreate(array $attributes = [], array $values = [])
     * @method RoomAdditional firstOrFail(array $columns = ['*'])
     * @method RoomAdditional firstOrNew(array $attributes = [], array $values = [])
     * @method RoomAdditional firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RoomAdditional forceCreate(array $attributes)
     * @method _IH_RoomAdditional_C|RoomAdditional[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RoomAdditional_C|RoomAdditional[] get(array|string $columns = ['*'])
     * @method RoomAdditional getModel()
     * @method RoomAdditional[] getModels(array|string $columns = ['*'])
     * @method _IH_RoomAdditional_C|RoomAdditional[] hydrate(array $items)
     * @method RoomAdditional make(array $attributes = [])
     * @method RoomAdditional newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RoomAdditional[]|_IH_RoomAdditional_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RoomAdditional[]|_IH_RoomAdditional_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RoomAdditional sole(array|string $columns = ['*'])
     * @method RoomAdditional updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RoomAdditional_QB extends _BaseBuilder {}
    
    /**
     * @method RoomPackage shift(int $count = 1)
     * @method RoomPackage pop(int $count = 1)
     * @method RoomPackage get($key, $default = null)
     * @method RoomPackage pull($key, $default = null)
     * @method RoomPackage first(callable $callback = null, $default = null)
     * @method RoomPackage firstWhere(string $key, $operator = null, $value = null)
     * @method RoomPackage find($key, $default = null)
     * @method RoomPackage[] all()
     * @method RoomPackage last(callable $callback = null, $default = null)
     */
    class _IH_RoomPackage_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RoomPackage[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_RoomPackage_QB whereId($value)
     * @method _IH_RoomPackage_QB whereHotelId($value)
     * @method _IH_RoomPackage_QB whereName($value)
     * @method _IH_RoomPackage_QB wherePrice($value)
     * @method _IH_RoomPackage_QB whereDescription($value)
     * @method _IH_RoomPackage_QB whereStatus($value)
     * @method _IH_RoomPackage_QB whereCreatedBy($value)
     * @method _IH_RoomPackage_QB whereUpdatedBy($value)
     * @method _IH_RoomPackage_QB whereCreatedAt($value)
     * @method _IH_RoomPackage_QB whereUpdatedAt($value)
     * @method RoomPackage baseSole(array|string $columns = ['*'])
     * @method RoomPackage create(array $attributes = [])
     * @method _IH_RoomPackage_C|RoomPackage[] cursor()
     * @method RoomPackage|null|_IH_RoomPackage_C|RoomPackage[] find($id, array $columns = ['*'])
     * @method _IH_RoomPackage_C|RoomPackage[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RoomPackage|_IH_RoomPackage_C|RoomPackage[] findOrFail($id, array $columns = ['*'])
     * @method RoomPackage|_IH_RoomPackage_C|RoomPackage[] findOrNew($id, array $columns = ['*'])
     * @method RoomPackage first(array|string $columns = ['*'])
     * @method RoomPackage firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RoomPackage firstOrCreate(array $attributes = [], array $values = [])
     * @method RoomPackage firstOrFail(array $columns = ['*'])
     * @method RoomPackage firstOrNew(array $attributes = [], array $values = [])
     * @method RoomPackage firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RoomPackage forceCreate(array $attributes)
     * @method _IH_RoomPackage_C|RoomPackage[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RoomPackage_C|RoomPackage[] get(array|string $columns = ['*'])
     * @method RoomPackage getModel()
     * @method RoomPackage[] getModels(array|string $columns = ['*'])
     * @method _IH_RoomPackage_C|RoomPackage[] hydrate(array $items)
     * @method RoomPackage make(array $attributes = [])
     * @method RoomPackage newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RoomPackage[]|_IH_RoomPackage_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RoomPackage[]|_IH_RoomPackage_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RoomPackage sole(array|string $columns = ['*'])
     * @method RoomPackage updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RoomPackage_QB extends _BaseBuilder {}
    
    /**
     * @method RoomPrice shift(int $count = 1)
     * @method RoomPrice pop(int $count = 1)
     * @method RoomPrice get($key, $default = null)
     * @method RoomPrice pull($key, $default = null)
     * @method RoomPrice first(callable $callback = null, $default = null)
     * @method RoomPrice firstWhere(string $key, $operator = null, $value = null)
     * @method RoomPrice find($key, $default = null)
     * @method RoomPrice[] all()
     * @method RoomPrice last(callable $callback = null, $default = null)
     */
    class _IH_RoomPrice_C extends _BaseCollection {
        /**
         * @param int $size
         * @return RoomPrice[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_RoomPrice_QB whereId($value)
     * @method _IH_RoomPrice_QB whereHotelId($value)
     * @method _IH_RoomPrice_QB whereTypeId($value)
     * @method _IH_RoomPrice_QB wherePrice($value)
     * @method _IH_RoomPrice_QB whereDescription($value)
     * @method _IH_RoomPrice_QB whereCreatedBy($value)
     * @method _IH_RoomPrice_QB whereUpdatedBy($value)
     * @method _IH_RoomPrice_QB whereCreatedAt($value)
     * @method _IH_RoomPrice_QB whereUpdatedAt($value)
     * @method RoomPrice baseSole(array|string $columns = ['*'])
     * @method RoomPrice create(array $attributes = [])
     * @method _IH_RoomPrice_C|RoomPrice[] cursor()
     * @method RoomPrice|null|_IH_RoomPrice_C|RoomPrice[] find($id, array $columns = ['*'])
     * @method _IH_RoomPrice_C|RoomPrice[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method RoomPrice|_IH_RoomPrice_C|RoomPrice[] findOrFail($id, array $columns = ['*'])
     * @method RoomPrice|_IH_RoomPrice_C|RoomPrice[] findOrNew($id, array $columns = ['*'])
     * @method RoomPrice first(array|string $columns = ['*'])
     * @method RoomPrice firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method RoomPrice firstOrCreate(array $attributes = [], array $values = [])
     * @method RoomPrice firstOrFail(array $columns = ['*'])
     * @method RoomPrice firstOrNew(array $attributes = [], array $values = [])
     * @method RoomPrice firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method RoomPrice forceCreate(array $attributes)
     * @method _IH_RoomPrice_C|RoomPrice[] fromQuery(string $query, array $bindings = [])
     * @method _IH_RoomPrice_C|RoomPrice[] get(array|string $columns = ['*'])
     * @method RoomPrice getModel()
     * @method RoomPrice[] getModels(array|string $columns = ['*'])
     * @method _IH_RoomPrice_C|RoomPrice[] hydrate(array $items)
     * @method RoomPrice make(array $attributes = [])
     * @method RoomPrice newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|RoomPrice[]|_IH_RoomPrice_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|RoomPrice[]|_IH_RoomPrice_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method RoomPrice sole(array|string $columns = ['*'])
     * @method RoomPrice updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_RoomPrice_QB extends _BaseBuilder {}
    
    /**
     * @method Room shift(int $count = 1)
     * @method Room pop(int $count = 1)
     * @method Room get($key, $default = null)
     * @method Room pull($key, $default = null)
     * @method Room first(callable $callback = null, $default = null)
     * @method Room firstWhere(string $key, $operator = null, $value = null)
     * @method Room find($key, $default = null)
     * @method Room[] all()
     * @method Room last(callable $callback = null, $default = null)
     */
    class _IH_Room_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Room[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Room_QB whereId($value)
     * @method _IH_Room_QB whereHotelId($value)
     * @method _IH_Room_QB whereTypeId($value)
     * @method _IH_Room_QB whereNumber($value)
     * @method _IH_Room_QB whereDescription($value)
     * @method _IH_Room_QB whereStatusId($value)
     * @method _IH_Room_QB whereCreatedBy($value)
     * @method _IH_Room_QB whereUpdatedBy($value)
     * @method _IH_Room_QB whereCreatedAt($value)
     * @method _IH_Room_QB whereUpdatedAt($value)
     * @method _IH_Room_QB whereInactiveReason($value)
     * @method Room baseSole(array|string $columns = ['*'])
     * @method Room create(array $attributes = [])
     * @method _IH_Room_C|Room[] cursor()
     * @method Room|null|_IH_Room_C|Room[] find($id, array $columns = ['*'])
     * @method _IH_Room_C|Room[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Room|_IH_Room_C|Room[] findOrFail($id, array $columns = ['*'])
     * @method Room|_IH_Room_C|Room[] findOrNew($id, array $columns = ['*'])
     * @method Room first(array|string $columns = ['*'])
     * @method Room firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Room firstOrCreate(array $attributes = [], array $values = [])
     * @method Room firstOrFail(array $columns = ['*'])
     * @method Room firstOrNew(array $attributes = [], array $values = [])
     * @method Room firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Room forceCreate(array $attributes)
     * @method _IH_Room_C|Room[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Room_C|Room[] get(array|string $columns = ['*'])
     * @method Room getModel()
     * @method Room[] getModels(array|string $columns = ['*'])
     * @method _IH_Room_C|Room[] hydrate(array $items)
     * @method Room make(array $attributes = [])
     * @method Room newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Room[]|_IH_Room_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Room[]|_IH_Room_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Room sole(array|string $columns = ['*'])
     * @method Room updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Room_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Setting {

    use App\Models\Setting\Category;
    use App\Models\Setting\Group;
    use App\Models\Setting\GroupModul;
    use App\Models\Setting\Master;
    use App\Models\Setting\Menu;
    use App\Models\Setting\MenuAccess;
    use App\Models\Setting\Modul;
    use App\Models\Setting\Parameter;
    use App\Models\Setting\SubModul;
    use App\Models\Setting\User;
    use App\Models\Setting\UserAccess;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method Category shift(int $count = 1)
     * @method Category pop(int $count = 1)
     * @method Category get($key, $default = null)
     * @method Category pull($key, $default = null)
     * @method Category first(callable $callback = null, $default = null)
     * @method Category firstWhere(string $key, $operator = null, $value = null)
     * @method Category find($key, $default = null)
     * @method Category[] all()
     * @method Category last(callable $callback = null, $default = null)
     */
    class _IH_Category_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Category[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Category baseSole(array|string $columns = ['*'])
     * @method Category create(array $attributes = [])
     * @method _IH_Category_C|Category[] cursor()
     * @method Category|null|_IH_Category_C|Category[] find($id, array $columns = ['*'])
     * @method _IH_Category_C|Category[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Category|_IH_Category_C|Category[] findOrFail($id, array $columns = ['*'])
     * @method Category|_IH_Category_C|Category[] findOrNew($id, array $columns = ['*'])
     * @method Category first(array|string $columns = ['*'])
     * @method Category firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Category firstOrCreate(array $attributes = [], array $values = [])
     * @method Category firstOrFail(array $columns = ['*'])
     * @method Category firstOrNew(array $attributes = [], array $values = [])
     * @method Category firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Category forceCreate(array $attributes)
     * @method _IH_Category_C|Category[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Category_C|Category[] get(array|string $columns = ['*'])
     * @method Category getModel()
     * @method Category[] getModels(array|string $columns = ['*'])
     * @method _IH_Category_C|Category[] hydrate(array $items)
     * @method Category make(array $attributes = [])
     * @method Category newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Category[]|_IH_Category_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Category[]|_IH_Category_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Category sole(array|string $columns = ['*'])
     * @method Category updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Category_QB extends _BaseBuilder {}
    
    /**
     * @method GroupModul shift(int $count = 1)
     * @method GroupModul pop(int $count = 1)
     * @method GroupModul get($key, $default = null)
     * @method GroupModul pull($key, $default = null)
     * @method GroupModul first(callable $callback = null, $default = null)
     * @method GroupModul firstWhere(string $key, $operator = null, $value = null)
     * @method GroupModul find($key, $default = null)
     * @method GroupModul[] all()
     * @method GroupModul last(callable $callback = null, $default = null)
     */
    class _IH_GroupModul_C extends _BaseCollection {
        /**
         * @param int $size
         * @return GroupModul[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method GroupModul baseSole(array|string $columns = ['*'])
     * @method GroupModul create(array $attributes = [])
     * @method _IH_GroupModul_C|GroupModul[] cursor()
     * @method GroupModul|null|_IH_GroupModul_C|GroupModul[] find($id, array $columns = ['*'])
     * @method _IH_GroupModul_C|GroupModul[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method GroupModul|_IH_GroupModul_C|GroupModul[] findOrFail($id, array $columns = ['*'])
     * @method GroupModul|_IH_GroupModul_C|GroupModul[] findOrNew($id, array $columns = ['*'])
     * @method GroupModul first(array|string $columns = ['*'])
     * @method GroupModul firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method GroupModul firstOrCreate(array $attributes = [], array $values = [])
     * @method GroupModul firstOrFail(array $columns = ['*'])
     * @method GroupModul firstOrNew(array $attributes = [], array $values = [])
     * @method GroupModul firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method GroupModul forceCreate(array $attributes)
     * @method _IH_GroupModul_C|GroupModul[] fromQuery(string $query, array $bindings = [])
     * @method _IH_GroupModul_C|GroupModul[] get(array|string $columns = ['*'])
     * @method GroupModul getModel()
     * @method GroupModul[] getModels(array|string $columns = ['*'])
     * @method _IH_GroupModul_C|GroupModul[] hydrate(array $items)
     * @method GroupModul make(array $attributes = [])
     * @method GroupModul newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|GroupModul[]|_IH_GroupModul_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|GroupModul[]|_IH_GroupModul_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method GroupModul sole(array|string $columns = ['*'])
     * @method GroupModul updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_GroupModul_QB extends _BaseBuilder {}
    
    /**
     * @method Group shift(int $count = 1)
     * @method Group pop(int $count = 1)
     * @method Group get($key, $default = null)
     * @method Group pull($key, $default = null)
     * @method Group first(callable $callback = null, $default = null)
     * @method Group firstWhere(string $key, $operator = null, $value = null)
     * @method Group find($key, $default = null)
     * @method Group[] all()
     * @method Group last(callable $callback = null, $default = null)
     */
    class _IH_Group_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Group[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Group baseSole(array|string $columns = ['*'])
     * @method Group create(array $attributes = [])
     * @method _IH_Group_C|Group[] cursor()
     * @method Group|null|_IH_Group_C|Group[] find($id, array $columns = ['*'])
     * @method _IH_Group_C|Group[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Group|_IH_Group_C|Group[] findOrFail($id, array $columns = ['*'])
     * @method Group|_IH_Group_C|Group[] findOrNew($id, array $columns = ['*'])
     * @method Group first(array|string $columns = ['*'])
     * @method Group firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Group firstOrCreate(array $attributes = [], array $values = [])
     * @method Group firstOrFail(array $columns = ['*'])
     * @method Group firstOrNew(array $attributes = [], array $values = [])
     * @method Group firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Group forceCreate(array $attributes)
     * @method _IH_Group_C|Group[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Group_C|Group[] get(array|string $columns = ['*'])
     * @method Group getModel()
     * @method Group[] getModels(array|string $columns = ['*'])
     * @method _IH_Group_C|Group[] hydrate(array $items)
     * @method Group make(array $attributes = [])
     * @method Group newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Group[]|_IH_Group_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Group[]|_IH_Group_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Group sole(array|string $columns = ['*'])
     * @method Group updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Group_QB extends _BaseBuilder {}
    
    /**
     * @method Master shift(int $count = 1)
     * @method Master pop(int $count = 1)
     * @method Master get($key, $default = null)
     * @method Master pull($key, $default = null)
     * @method Master first(callable $callback = null, $default = null)
     * @method Master firstWhere(string $key, $operator = null, $value = null)
     * @method Master find($key, $default = null)
     * @method Master[] all()
     * @method Master last(callable $callback = null, $default = null)
     */
    class _IH_Master_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Master[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Master baseSole(array|string $columns = ['*'])
     * @method Master create(array $attributes = [])
     * @method _IH_Master_C|Master[] cursor()
     * @method Master|null|_IH_Master_C|Master[] find($id, array $columns = ['*'])
     * @method _IH_Master_C|Master[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Master|_IH_Master_C|Master[] findOrFail($id, array $columns = ['*'])
     * @method Master|_IH_Master_C|Master[] findOrNew($id, array $columns = ['*'])
     * @method Master first(array|string $columns = ['*'])
     * @method Master firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Master firstOrCreate(array $attributes = [], array $values = [])
     * @method Master firstOrFail(array $columns = ['*'])
     * @method Master firstOrNew(array $attributes = [], array $values = [])
     * @method Master firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Master forceCreate(array $attributes)
     * @method _IH_Master_C|Master[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Master_C|Master[] get(array|string $columns = ['*'])
     * @method Master getModel()
     * @method Master[] getModels(array|string $columns = ['*'])
     * @method _IH_Master_C|Master[] hydrate(array $items)
     * @method Master make(array $attributes = [])
     * @method Master newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Master[]|_IH_Master_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Master[]|_IH_Master_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Master sole(array|string $columns = ['*'])
     * @method Master updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Master_QB active()
     */
    class _IH_Master_QB extends _BaseBuilder {}
    
    /**
     * @method MenuAccess shift(int $count = 1)
     * @method MenuAccess pop(int $count = 1)
     * @method MenuAccess get($key, $default = null)
     * @method MenuAccess pull($key, $default = null)
     * @method MenuAccess first(callable $callback = null, $default = null)
     * @method MenuAccess firstWhere(string $key, $operator = null, $value = null)
     * @method MenuAccess find($key, $default = null)
     * @method MenuAccess[] all()
     * @method MenuAccess last(callable $callback = null, $default = null)
     */
    class _IH_MenuAccess_C extends _BaseCollection {
        /**
         * @param int $size
         * @return MenuAccess[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method MenuAccess baseSole(array|string $columns = ['*'])
     * @method MenuAccess create(array $attributes = [])
     * @method _IH_MenuAccess_C|MenuAccess[] cursor()
     * @method MenuAccess|null|_IH_MenuAccess_C|MenuAccess[] find($id, array $columns = ['*'])
     * @method _IH_MenuAccess_C|MenuAccess[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method MenuAccess|_IH_MenuAccess_C|MenuAccess[] findOrFail($id, array $columns = ['*'])
     * @method MenuAccess|_IH_MenuAccess_C|MenuAccess[] findOrNew($id, array $columns = ['*'])
     * @method MenuAccess first(array|string $columns = ['*'])
     * @method MenuAccess firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method MenuAccess firstOrCreate(array $attributes = [], array $values = [])
     * @method MenuAccess firstOrFail(array $columns = ['*'])
     * @method MenuAccess firstOrNew(array $attributes = [], array $values = [])
     * @method MenuAccess firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method MenuAccess forceCreate(array $attributes)
     * @method _IH_MenuAccess_C|MenuAccess[] fromQuery(string $query, array $bindings = [])
     * @method _IH_MenuAccess_C|MenuAccess[] get(array|string $columns = ['*'])
     * @method MenuAccess getModel()
     * @method MenuAccess[] getModels(array|string $columns = ['*'])
     * @method _IH_MenuAccess_C|MenuAccess[] hydrate(array $items)
     * @method MenuAccess make(array $attributes = [])
     * @method MenuAccess newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|MenuAccess[]|_IH_MenuAccess_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|MenuAccess[]|_IH_MenuAccess_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method MenuAccess sole(array|string $columns = ['*'])
     * @method MenuAccess updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_MenuAccess_QB extends _BaseBuilder {}
    
    /**
     * @method Menu shift(int $count = 1)
     * @method Menu pop(int $count = 1)
     * @method Menu get($key, $default = null)
     * @method Menu pull($key, $default = null)
     * @method Menu first(callable $callback = null, $default = null)
     * @method Menu firstWhere(string $key, $operator = null, $value = null)
     * @method Menu find($key, $default = null)
     * @method Menu[] all()
     * @method Menu last(callable $callback = null, $default = null)
     */
    class _IH_Menu_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Menu[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_Menu_QB whereFullScreen($value)
     * @method Menu baseSole(array|string $columns = ['*'])
     * @method Menu create(array $attributes = [])
     * @method _IH_Menu_C|Menu[] cursor()
     * @method Menu|null|_IH_Menu_C|Menu[] find($id, array $columns = ['*'])
     * @method _IH_Menu_C|Menu[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Menu|_IH_Menu_C|Menu[] findOrFail($id, array $columns = ['*'])
     * @method Menu|_IH_Menu_C|Menu[] findOrNew($id, array $columns = ['*'])
     * @method Menu first(array|string $columns = ['*'])
     * @method Menu firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Menu firstOrCreate(array $attributes = [], array $values = [])
     * @method Menu firstOrFail(array $columns = ['*'])
     * @method Menu firstOrNew(array $attributes = [], array $values = [])
     * @method Menu firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Menu forceCreate(array $attributes)
     * @method _IH_Menu_C|Menu[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Menu_C|Menu[] get(array|string $columns = ['*'])
     * @method Menu getModel()
     * @method Menu[] getModels(array|string $columns = ['*'])
     * @method _IH_Menu_C|Menu[] hydrate(array $items)
     * @method Menu make(array $attributes = [])
     * @method Menu newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Menu[]|_IH_Menu_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Menu[]|_IH_Menu_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Menu sole(array|string $columns = ['*'])
     * @method Menu updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Menu_QB active()
     */
    class _IH_Menu_QB extends _BaseBuilder {}
    
    /**
     * @method Modul shift(int $count = 1)
     * @method Modul pop(int $count = 1)
     * @method Modul get($key, $default = null)
     * @method Modul pull($key, $default = null)
     * @method Modul first(callable $callback = null, $default = null)
     * @method Modul firstWhere(string $key, $operator = null, $value = null)
     * @method Modul find($key, $default = null)
     * @method Modul[] all()
     * @method Modul last(callable $callback = null, $default = null)
     */
    class _IH_Modul_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Modul[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Modul baseSole(array|string $columns = ['*'])
     * @method Modul create(array $attributes = [])
     * @method _IH_Modul_C|Modul[] cursor()
     * @method Modul|null|_IH_Modul_C|Modul[] find($id, array $columns = ['*'])
     * @method _IH_Modul_C|Modul[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Modul|_IH_Modul_C|Modul[] findOrFail($id, array $columns = ['*'])
     * @method Modul|_IH_Modul_C|Modul[] findOrNew($id, array $columns = ['*'])
     * @method Modul first(array|string $columns = ['*'])
     * @method Modul firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Modul firstOrCreate(array $attributes = [], array $values = [])
     * @method Modul firstOrFail(array $columns = ['*'])
     * @method Modul firstOrNew(array $attributes = [], array $values = [])
     * @method Modul firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Modul forceCreate(array $attributes)
     * @method _IH_Modul_C|Modul[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Modul_C|Modul[] get(array|string $columns = ['*'])
     * @method Modul getModel()
     * @method Modul[] getModels(array|string $columns = ['*'])
     * @method _IH_Modul_C|Modul[] hydrate(array $items)
     * @method Modul make(array $attributes = [])
     * @method Modul newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Modul[]|_IH_Modul_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Modul[]|_IH_Modul_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Modul sole(array|string $columns = ['*'])
     * @method Modul updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Modul_QB active()
     */
    class _IH_Modul_QB extends _BaseBuilder {}
    
    /**
     * @method Parameter shift(int $count = 1)
     * @method Parameter pop(int $count = 1)
     * @method Parameter get($key, $default = null)
     * @method Parameter pull($key, $default = null)
     * @method Parameter first(callable $callback = null, $default = null)
     * @method Parameter firstWhere(string $key, $operator = null, $value = null)
     * @method Parameter find($key, $default = null)
     * @method Parameter[] all()
     * @method Parameter last(callable $callback = null, $default = null)
     */
    class _IH_Parameter_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Parameter[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method Parameter baseSole(array|string $columns = ['*'])
     * @method Parameter create(array $attributes = [])
     * @method _IH_Parameter_C|Parameter[] cursor()
     * @method Parameter|null|_IH_Parameter_C|Parameter[] find($id, array $columns = ['*'])
     * @method _IH_Parameter_C|Parameter[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method Parameter|_IH_Parameter_C|Parameter[] findOrFail($id, array $columns = ['*'])
     * @method Parameter|_IH_Parameter_C|Parameter[] findOrNew($id, array $columns = ['*'])
     * @method Parameter first(array|string $columns = ['*'])
     * @method Parameter firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method Parameter firstOrCreate(array $attributes = [], array $values = [])
     * @method Parameter firstOrFail(array $columns = ['*'])
     * @method Parameter firstOrNew(array $attributes = [], array $values = [])
     * @method Parameter firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Parameter forceCreate(array $attributes)
     * @method _IH_Parameter_C|Parameter[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Parameter_C|Parameter[] get(array|string $columns = ['*'])
     * @method Parameter getModel()
     * @method Parameter[] getModels(array|string $columns = ['*'])
     * @method _IH_Parameter_C|Parameter[] hydrate(array $items)
     * @method Parameter make(array $attributes = [])
     * @method Parameter newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Parameter[]|_IH_Parameter_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Parameter[]|_IH_Parameter_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Parameter sole(array|string $columns = ['*'])
     * @method Parameter updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Parameter_QB extends _BaseBuilder {}
    
    /**
     * @method SubModul shift(int $count = 1)
     * @method SubModul pop(int $count = 1)
     * @method SubModul get($key, $default = null)
     * @method SubModul pull($key, $default = null)
     * @method SubModul first(callable $callback = null, $default = null)
     * @method SubModul firstWhere(string $key, $operator = null, $value = null)
     * @method SubModul find($key, $default = null)
     * @method SubModul[] all()
     * @method SubModul last(callable $callback = null, $default = null)
     */
    class _IH_SubModul_C extends _BaseCollection {
        /**
         * @param int $size
         * @return SubModul[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method SubModul baseSole(array|string $columns = ['*'])
     * @method SubModul create(array $attributes = [])
     * @method _IH_SubModul_C|SubModul[] cursor()
     * @method SubModul|null|_IH_SubModul_C|SubModul[] find($id, array $columns = ['*'])
     * @method _IH_SubModul_C|SubModul[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method SubModul|_IH_SubModul_C|SubModul[] findOrFail($id, array $columns = ['*'])
     * @method SubModul|_IH_SubModul_C|SubModul[] findOrNew($id, array $columns = ['*'])
     * @method SubModul first(array|string $columns = ['*'])
     * @method SubModul firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method SubModul firstOrCreate(array $attributes = [], array $values = [])
     * @method SubModul firstOrFail(array $columns = ['*'])
     * @method SubModul firstOrNew(array $attributes = [], array $values = [])
     * @method SubModul firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method SubModul forceCreate(array $attributes)
     * @method _IH_SubModul_C|SubModul[] fromQuery(string $query, array $bindings = [])
     * @method _IH_SubModul_C|SubModul[] get(array|string $columns = ['*'])
     * @method SubModul getModel()
     * @method SubModul[] getModels(array|string $columns = ['*'])
     * @method _IH_SubModul_C|SubModul[] hydrate(array $items)
     * @method SubModul make(array $attributes = [])
     * @method SubModul newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|SubModul[]|_IH_SubModul_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|SubModul[]|_IH_SubModul_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method SubModul sole(array|string $columns = ['*'])
     * @method SubModul updateOrCreate(array $attributes, array $values = [])
     * @method _IH_SubModul_QB active()
     */
    class _IH_SubModul_QB extends _BaseBuilder {}
    
    /**
     * @method UserAccess shift(int $count = 1)
     * @method UserAccess pop(int $count = 1)
     * @method UserAccess get($key, $default = null)
     * @method UserAccess pull($key, $default = null)
     * @method UserAccess first(callable $callback = null, $default = null)
     * @method UserAccess firstWhere(string $key, $operator = null, $value = null)
     * @method UserAccess find($key, $default = null)
     * @method UserAccess[] all()
     * @method UserAccess last(callable $callback = null, $default = null)
     */
    class _IH_UserAccess_C extends _BaseCollection {
        /**
         * @param int $size
         * @return UserAccess[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method UserAccess baseSole(array|string $columns = ['*'])
     * @method UserAccess create(array $attributes = [])
     * @method _IH_UserAccess_C|UserAccess[] cursor()
     * @method UserAccess|null|_IH_UserAccess_C|UserAccess[] find($id, array $columns = ['*'])
     * @method _IH_UserAccess_C|UserAccess[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method UserAccess|_IH_UserAccess_C|UserAccess[] findOrFail($id, array $columns = ['*'])
     * @method UserAccess|_IH_UserAccess_C|UserAccess[] findOrNew($id, array $columns = ['*'])
     * @method UserAccess first(array|string $columns = ['*'])
     * @method UserAccess firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method UserAccess firstOrCreate(array $attributes = [], array $values = [])
     * @method UserAccess firstOrFail(array $columns = ['*'])
     * @method UserAccess firstOrNew(array $attributes = [], array $values = [])
     * @method UserAccess firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method UserAccess forceCreate(array $attributes)
     * @method _IH_UserAccess_C|UserAccess[] fromQuery(string $query, array $bindings = [])
     * @method _IH_UserAccess_C|UserAccess[] get(array|string $columns = ['*'])
     * @method UserAccess getModel()
     * @method UserAccess[] getModels(array|string $columns = ['*'])
     * @method _IH_UserAccess_C|UserAccess[] hydrate(array $items)
     * @method UserAccess make(array $attributes = [])
     * @method UserAccess newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|UserAccess[]|_IH_UserAccess_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|UserAccess[]|_IH_UserAccess_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method UserAccess sole(array|string $columns = ['*'])
     * @method UserAccess updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_UserAccess_QB extends _BaseBuilder {}
    
    /**
     * @method User shift(int $count = 1)
     * @method User pop(int $count = 1)
     * @method User get($key, $default = null)
     * @method User pull($key, $default = null)
     * @method User first(callable $callback = null, $default = null)
     * @method User firstWhere(string $key, $operator = null, $value = null)
     * @method User find($key, $default = null)
     * @method User[] all()
     * @method User last(callable $callback = null, $default = null)
     */
    class _IH_User_C extends _BaseCollection {
        /**
         * @param int $size
         * @return User[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method User baseSole(array|string $columns = ['*'])
     * @method User create(array $attributes = [])
     * @method _IH_User_C|User[] cursor()
     * @method User|null|_IH_User_C|User[] find($id, array $columns = ['*'])
     * @method _IH_User_C|User[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrFail($id, array $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrNew($id, array $columns = ['*'])
     * @method User first(array|string $columns = ['*'])
     * @method User firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method User firstOrCreate(array $attributes = [], array $values = [])
     * @method User firstOrFail(array $columns = ['*'])
     * @method User firstOrNew(array $attributes = [], array $values = [])
     * @method User firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method User forceCreate(array $attributes)
     * @method _IH_User_C|User[] fromQuery(string $query, array $bindings = [])
     * @method _IH_User_C|User[] get(array|string $columns = ['*'])
     * @method User getModel()
     * @method User[] getModels(array|string $columns = ['*'])
     * @method _IH_User_C|User[] hydrate(array $items)
     * @method User make(array $attributes = [])
     * @method User newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|User[]|_IH_User_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|User[]|_IH_User_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method User sole(array|string $columns = ['*'])
     * @method User updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_User_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\App\Models\Transaction {

    use App\Models\Transaction\HotelOrder;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method HotelOrder shift(int $count = 1)
     * @method HotelOrder pop(int $count = 1)
     * @method HotelOrder get($key, $default = null)
     * @method HotelOrder pull($key, $default = null)
     * @method HotelOrder first(callable $callback = null, $default = null)
     * @method HotelOrder firstWhere(string $key, $operator = null, $value = null)
     * @method HotelOrder find($key, $default = null)
     * @method HotelOrder[] all()
     * @method HotelOrder last(callable $callback = null, $default = null)
     */
    class _IH_HotelOrder_C extends _BaseCollection {
        /**
         * @param int $size
         * @return HotelOrder[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method _IH_HotelOrder_QB whereId($value)
     * @method _IH_HotelOrder_QB whereHotelId($value)
     * @method _IH_HotelOrder_QB whereName($value)
     * @method _IH_HotelOrder_QB whereIdentityNumber($value)
     * @method _IH_HotelOrder_QB whereAddress($value)
     * @method _IH_HotelOrder_QB whereProvinceId($value)
     * @method _IH_HotelOrder_QB whereCityId($value)
     * @method _IH_HotelOrder_QB wherePostalCode($value)
     * @method _IH_HotelOrder_QB whereEmail($value)
     * @method _IH_HotelOrder_QB wherePhoneNumber($value)
     * @method _IH_HotelOrder_QB whereCompanyName($value)
     * @method _IH_HotelOrder_QB whereArrivalDate($value)
     * @method _IH_HotelOrder_QB whereDepartureDate($value)
     * @method _IH_HotelOrder_QB whereNumberOfNights($value)
     * @method _IH_HotelOrder_QB whereNumberOfAdults($value)
     * @method _IH_HotelOrder_QB wherePackageId($value)
     * @method _IH_HotelOrder_QB whereRooms($value)
     * @method _IH_HotelOrder_QB whereExtraBed($value)
     * @method _IH_HotelOrder_QB wherePrice($value)
     * @method _IH_HotelOrder_QB whereDiscount($value)
     * @method _IH_HotelOrder_QB whereDiscountPrice($value)
     * @method _IH_HotelOrder_QB whereFixPrice($value)
     * @method _IH_HotelOrder_QB whereNote($value)
     * @method _IH_HotelOrder_QB whereStatus($value)
     * @method _IH_HotelOrder_QB wherePaymentMethod($value)
     * @method _IH_HotelOrder_QB wherePaymentDetail($value)
     * @method _IH_HotelOrder_QB whereCreatedBy($value)
     * @method _IH_HotelOrder_QB whereUpdatedBy($value)
     * @method _IH_HotelOrder_QB whereCreatedAt($value)
     * @method _IH_HotelOrder_QB whereUpdatedAt($value)
     * @method _IH_HotelOrder_QB wherePackageTotal($value)
     * @method _IH_HotelOrder_QB wherePackagePrice($value)
     * @method _IH_HotelOrder_QB whereExtraBedPrice($value)
     * @method _IH_HotelOrder_QB whereCompanyEmergencyName($value)
     * @method _IH_HotelOrder_QB whereCompanyPhone($value)
     * @method _IH_HotelOrder_QB whereCompanyAccomodation($value)
     * @method HotelOrder baseSole(array|string $columns = ['*'])
     * @method HotelOrder create(array $attributes = [])
     * @method _IH_HotelOrder_C|HotelOrder[] cursor()
     * @method HotelOrder|null|_IH_HotelOrder_C|HotelOrder[] find($id, array $columns = ['*'])
     * @method _IH_HotelOrder_C|HotelOrder[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method HotelOrder|_IH_HotelOrder_C|HotelOrder[] findOrFail($id, array $columns = ['*'])
     * @method HotelOrder|_IH_HotelOrder_C|HotelOrder[] findOrNew($id, array $columns = ['*'])
     * @method HotelOrder first(array|string $columns = ['*'])
     * @method HotelOrder firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method HotelOrder firstOrCreate(array $attributes = [], array $values = [])
     * @method HotelOrder firstOrFail(array $columns = ['*'])
     * @method HotelOrder firstOrNew(array $attributes = [], array $values = [])
     * @method HotelOrder firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method HotelOrder forceCreate(array $attributes)
     * @method _IH_HotelOrder_C|HotelOrder[] fromQuery(string $query, array $bindings = [])
     * @method _IH_HotelOrder_C|HotelOrder[] get(array|string $columns = ['*'])
     * @method HotelOrder getModel()
     * @method HotelOrder[] getModels(array|string $columns = ['*'])
     * @method _IH_HotelOrder_C|HotelOrder[] hydrate(array $items)
     * @method HotelOrder make(array $attributes = [])
     * @method HotelOrder newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|HotelOrder[]|_IH_HotelOrder_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|HotelOrder[]|_IH_HotelOrder_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method HotelOrder sole(array|string $columns = ['*'])
     * @method HotelOrder updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_HotelOrder_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\Illuminate\Notifications {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Notifications\DatabaseNotification;
    use Illuminate\Notifications\DatabaseNotificationCollection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method DatabaseNotification shift(int $count = 1)
     * @method DatabaseNotification pop(int $count = 1)
     * @method DatabaseNotification get($key, $default = null)
     * @method DatabaseNotification pull($key, $default = null)
     * @method DatabaseNotification first(callable $callback = null, $default = null)
     * @method DatabaseNotification firstWhere(string $key, $operator = null, $value = null)
     * @method DatabaseNotification find($key, $default = null)
     * @method DatabaseNotification[] all()
     * @method DatabaseNotification last(callable $callback = null, $default = null)
     * @mixin DatabaseNotificationCollection
     */
    class _IH_DatabaseNotification_C extends _BaseCollection {
        /**
         * @param int $size
         * @return DatabaseNotification[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method DatabaseNotification baseSole(array|string $columns = ['*'])
     * @method DatabaseNotification create(array $attributes = [])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] cursor()
     * @method DatabaseNotification|null|_IH_DatabaseNotification_C|DatabaseNotification[] find($id, array $columns = ['*'])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method DatabaseNotification|_IH_DatabaseNotification_C|DatabaseNotification[] findOrFail($id, array $columns = ['*'])
     * @method DatabaseNotification|_IH_DatabaseNotification_C|DatabaseNotification[] findOrNew($id, array $columns = ['*'])
     * @method DatabaseNotification first(array|string $columns = ['*'])
     * @method DatabaseNotification firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method DatabaseNotification firstOrCreate(array $attributes = [], array $values = [])
     * @method DatabaseNotification firstOrFail(array $columns = ['*'])
     * @method DatabaseNotification firstOrNew(array $attributes = [], array $values = [])
     * @method DatabaseNotification firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method DatabaseNotification forceCreate(array $attributes)
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] fromQuery(string $query, array $bindings = [])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] get(array|string $columns = ['*'])
     * @method DatabaseNotification getModel()
     * @method DatabaseNotification[] getModels(array|string $columns = ['*'])
     * @method _IH_DatabaseNotification_C|DatabaseNotification[] hydrate(array $items)
     * @method DatabaseNotification make(array $attributes = [])
     * @method DatabaseNotification newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|DatabaseNotification[]|_IH_DatabaseNotification_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|DatabaseNotification[]|_IH_DatabaseNotification_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method DatabaseNotification sole(array|string $columns = ['*'])
     * @method DatabaseNotification updateOrCreate(array $attributes, array $values = [])
     * @method _IH_DatabaseNotification_QB read()
     * @method _IH_DatabaseNotification_QB unread()
     */
    class _IH_DatabaseNotification_QB extends _BaseBuilder {}
}

namespace LaravelIdea\Helper\Laravel\Sanctum {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use Laravel\Sanctum\PersonalAccessToken;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    
    /**
     * @method PersonalAccessToken shift(int $count = 1)
     * @method PersonalAccessToken pop(int $count = 1)
     * @method PersonalAccessToken get($key, $default = null)
     * @method PersonalAccessToken pull($key, $default = null)
     * @method PersonalAccessToken first(callable $callback = null, $default = null)
     * @method PersonalAccessToken firstWhere(string $key, $operator = null, $value = null)
     * @method PersonalAccessToken find($key, $default = null)
     * @method PersonalAccessToken[] all()
     * @method PersonalAccessToken last(callable $callback = null, $default = null)
     */
    class _IH_PersonalAccessToken_C extends _BaseCollection {
        /**
         * @param int $size
         * @return PersonalAccessToken[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }
    
    /**
     * @method PersonalAccessToken baseSole(array|string $columns = ['*'])
     * @method PersonalAccessToken create(array $attributes = [])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] cursor()
     * @method PersonalAccessToken|null|_IH_PersonalAccessToken_C|PersonalAccessToken[] find($id, array $columns = ['*'])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] findMany(array|Arrayable $ids, array $columns = ['*'])
     * @method PersonalAccessToken|_IH_PersonalAccessToken_C|PersonalAccessToken[] findOrFail($id, array $columns = ['*'])
     * @method PersonalAccessToken|_IH_PersonalAccessToken_C|PersonalAccessToken[] findOrNew($id, array $columns = ['*'])
     * @method PersonalAccessToken first(array|string $columns = ['*'])
     * @method PersonalAccessToken firstOr(array|\Closure $columns = ['*'], \Closure $callback = null)
     * @method PersonalAccessToken firstOrCreate(array $attributes = [], array $values = [])
     * @method PersonalAccessToken firstOrFail(array $columns = ['*'])
     * @method PersonalAccessToken firstOrNew(array $attributes = [], array $values = [])
     * @method PersonalAccessToken firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method PersonalAccessToken forceCreate(array $attributes)
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] fromQuery(string $query, array $bindings = [])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] get(array|string $columns = ['*'])
     * @method PersonalAccessToken getModel()
     * @method PersonalAccessToken[] getModels(array|string $columns = ['*'])
     * @method _IH_PersonalAccessToken_C|PersonalAccessToken[] hydrate(array $items)
     * @method PersonalAccessToken make(array $attributes = [])
     * @method PersonalAccessToken newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|PersonalAccessToken[]|_IH_PersonalAccessToken_C paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|PersonalAccessToken[]|_IH_PersonalAccessToken_C simplePaginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method PersonalAccessToken sole(array|string $columns = ['*'])
     * @method PersonalAccessToken updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_PersonalAccessToken_QB extends _BaseBuilder {}
}