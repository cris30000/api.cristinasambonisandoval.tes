<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class City extends Model
{
    use HasFactory;
  

   protected $fillable = [
    'nombreciudad'
    ]; //Campos que se van a asignacion masiva:

    //LISTAS BLANCAS
    protected $allowIncluded = [
        'graduate', 
        'graduate.city',
        //'graduate.company',
        //'soldiers.services'
        ]; //las posibles Querys que se pueden realizar


    protected $allowFilter = ['id', 'nombreciudad'];
    protected $allowSort = ['id', 'nombreciudad'];


    //relacion uno a muchos porqur  un cuerpo de soldados puede tener muchos soldados pero un soldado solo puede pertenecer a un cuerpo de soldados
    public function companygraduates()
    {
        return $this->hasMany(Companygraduate::class);
    }


    public function scopeIncluded(Builder $query)
    {
        if (
            empty($this->allowIncluded) || 
            empty(request('included'))
            ) { // validamos que la lista blanca y la variable included enviada a travez de HTTP no este en vacia.
            return $query;
            
            ///army_corps?included=soldiers
            ///army_corps?included=soldiers.quarter,soldiers.company
        }


        // return request('included');

        $relations  = explode(',', request('included')); //['posts','relation2']//recuperamos el valor de la variable included y separa sus valores por una coma

         //return $relations;


        $allowIncluded = collect($this->allowIncluded); //colocamos en una colecion lo que tiene $allowIncluded en este caso = ['posts','posts.user']

        foreach ($relations as $key => $relationship) { //recorremos el array de relaciones

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

       // return $relations;

        return $query->with($relations); //se ejecuta el query con lo que tiene $relations en ultimas es el valor en la url de included

    }

    // scope Filter para filtrar los resultados de acuerdo a los campos que se le indiquen en la URL, por ejemplo: http://soldados.test/army_corps?filter[denominacion]=Infanteria

    public function scopeFilter(Builder $query)
    {

        if (
            empty($this->allowFilter) || 
            empty(request('filter'))) {
            return $query;
        }

        $filters = request('filter');

        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {

            if ($allowFilter->contains($filter)) {

                $query->where(
                    $filter, 
                    'LIKE', 
                    '%' . $value . '%'
                    );//nos retorna todos los registros que conincidad, asi sea en una porcion del texto
            }
        }
        return $query;
        ///soldiers?filter[nombre]=Juan
        ///army_corps?filter[denominacion]=Infanteria

    }

    //Scope Sort para ordenar los resultados de acuerdo a los campos que se le indiquen en la URL, por ejemplo: http://soldados.test/army_corps?sort=denominacion o http://soldados.test/army_corps?sort=-denominacion (el menos (-) es para ordenar de forma descendente)
    public function scopeSort(Builder $query)
    {

     if (empty($this->allowSort) || 
     empty(request('sort'))
     ) {
            return $query;//validamos que la lista blanca y la variable sort enviada a travez de HTTP no este en vacia.
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

      foreach ($sortFields as $sortField) {

            $direction = 'asc';

            if(substr($sortField, 0,1)=='-'){ //cambiamos la consulta a 'desc'si el usuario antecede el menos (-) en el valor de la variable sort
                $direction = 'desc';
                $sortField = substr($sortField,1);//copiamos el valor de sort pero omitiendo, el primer caracter por eso inicia desde el indice 1
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);//ejecutamos la query con la direccion deseada sea 'asc' o 'desc'
            }
        }

        return $query;
        //http://soldados.test/army_corps?sort=denominacion
        ///army_corps?sort=denominacion
        
    }


    // Scope GetOrPaginate para paginar los resultados de acuerdo al valor que se le indique en la URL, por ejemplo: http://soldados.test/army_corps?perPage=2 (el valor de perPage es el numero de registros que se desea mostrar por pagina)
    public function scopeGetOrPaginate(Builder $query)
    {
      if (request('perPage')) {
            $perPage = intval(request('perPage'));//transformamos la cadena que llega en un numero.

            if($perPage){//como la funcion intval retorna 0 si no puede hacer la conversion 0  es = false
                return $query->paginate($perPage);//retornamos la consulta de acuerdo a la ingresado en la vaiable $perPage
            }


         }
           return $query->get();//sino se pasa el valor de $perPage en la URL se pasan todos los registros.
        //http://soldados.test/army_corps?perPage=2
        ///army_corps?perPage=2
    }
}
