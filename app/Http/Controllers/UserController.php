<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\QueryUserService;
use App\Http\Services\UserService;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\stringContains;

class UserController extends Controller
{
    protected $baseRepositoryUser;

    public function __construct(UserService $baseRepository)
    {
        $this->baseRepositoryUser = $baseRepository;
    }
    public function all(Request $request){
        $search = $request->search ?? null;
        $conditions =$request->conditions ?? null;
        $sortCatsAge = $request->sortCatsAge ?? null;
        $userSearch = $request->userSearch ?? null;
        $userCreatedSearch = $request->userCreatedSearch ?? null;
        $userSearchById = $request->userSearchById ?? null;
        $userSearchWithoutId = $request->userSearchWithoutId ?? null;
        $showVerifiedUsersEmail = $request->showVerifiedUsersEmail ?? null;
        $showNotVerifiedUsersEmail = $request->showNotVerifiedUsersEmail ?? null;;

        $orderBy = $request->orderBy ?? 'users.id';
        $orderType = $request->orderType ?? 'ASC';



        //$temp = 'tailong';
//        $users = DB::table("users")
//            ->join('cats','cats.user_id','=','users.id')
//            ->select("users.id","users.name","users.email","cats.name as Cat")
//            ->paginate(3);
       //   ->groupBy("users.name")   ésto es el group by que no nos sirve para nada justo ahora...
          //->where('race','=','gay')
          //->where('cats.name','LIKE','%Tailong')
            //->get();
     /*   while ($i<count($users)){
            $users[$i]->cats;
            $i++;
        }*/
        // $repository = new BaseRepository(new User());
        //$users = $repository->getAll();
        /* $users = User::query()

        ->join('cats','cats.user_id','=','users.id')
        ->select("users.id","users.name as Nombre","users.email","cats.name as Gato","cats.age as Edad")
        ->when($age,function($query,$age){
            $query->where('cats.age','=',$age);
        })
        ->search($search)
        ->orderBy($orderBy,$orderType)
        ->get();
        //->groupBy("users.name");*/
        $users=$this->baseRepositoryUser->indexQuery([
            'relationships'=>[
                'leftjoin'=>['cats','cats.user_id','users.id'],
            ],
            'select'=>['users.id','users.name as Nombre','users.email','cats.name as Gato','cats.age as edad','users.updated_at as fecha de creacion'],
            'groupBy' => ['users.id','users.name','users.email'],
            'orderBy' => ['cats.name' => 'DESC'],
            'conditions'=> $conditions,
            'search'=>$search,
        ]);
        //return $conditions;
        return response()->json($users);
    }

    public function show(Request $request, $id){
        $user = $this->baseRepositoryUser->getByIdRelationships($id,['cats']);
        if(!$user){
            return response()->json('User not found', 404);
        }
        return response()->json($user);
    }

    public function store(Request $request){
        //$params = $request->all();
        //$user = new User();
        $user = $this->baseRepositoryUser->create($request->all());

        //$user->fill($params);
       // $user->save();
        return response()->json($user);
    }
    public function update(Request $request, $id){
        //$params = $request->all();
        //$user = User::find($id);
        $user = $this->baseRepositoryUser->update($id, $request->all());
        if(!$user){
            return response()->json('User not found', 404);
        }
        //$user->fill($params);
        //$user->save();
        return response()->json($user);
    }
    public function destroy(Request $request, $id){
        $user = $this->baseRepositoryUser->delete($id);
        if(!$user){
            return response()->json('User not found', 404);
        }
        $user->delete();
        return response()->json('User deleted successfully', 200);
    }

    public function test (Request $request)
    {

        $usuarios = [
            [
                'id' => 1,
                'nombre' => 'Carlos Méndez',
                'email' => 'carlos.mendez@example.com',
                'telefono' => '5512345678',
                'edad' => 16,
                'fecha_nacimiento' => '2008-03-15',
                'menor_de_edad' => true,
                'tipo_sangre' => 'O+',
                'genero' => 'Masculino',
                'direccion' => 'Calle Falsa 123, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '01000',
                'ocupacion' => 'Estudiante',
                'nivel_estudios' => 'Secundaria',
                'estado_civil' => 'Soltero',
                'activo' => true,
                'fecha_registro' => '2024-01-10',
                'ultimo_acceso' => '2024-06-15 10:30:00',
                'puntaje' => 45,
                'compras_realizadas' => 0,
                'notificaciones_activas' => true
            ],
            [
                'id' => 2,
                'nombre' => 'Ana Gómez',
                'email' => 'ana.gomez@example.com',
                'telefono' => '5523456789',
                'edad' => 17,
                'fecha_nacimiento' => '2007-08-22',
                'menor_de_edad' => true,
                'tipo_sangre' => 'A-',
                'genero' => 'Femenino',
                'direccion' => 'Av. Reforma 456, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '06500',
                'ocupacion' => 'Estudiante',
                'nivel_estudios' => 'Preparatoria',
                'estado_civil' => 'Soltero',
                'activo' => true,
                'fecha_registro' => '2024-02-15',
                'ultimo_acceso' => '2024-06-14 14:20:00',
                'puntaje' => 92,
                'compras_realizadas' => 1,
                'notificaciones_activas' => false
            ],
            [
                'id' => 3,
                'nombre' => 'Luis Torres',
                'email' => 'luis.torres@example.com',
                'telefono' => '5534567890',
                'edad' => 15,
                'fecha_nacimiento' => '2009-11-30',
                'menor_de_edad' => true,
                'tipo_sangre' => 'B+',
                'genero' => 'Masculino',
                'direccion' => 'Insurgentes Sur 789, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '03810',
                'ocupacion' => 'Estudiante',
                'nivel_estudios' => 'Secundaria',
                'estado_civil' => 'Soltero',
                'activo' => true,
                'fecha_registro' => '2024-03-20',
                'ultimo_acceso' => '2024-06-13 09:45:00',
                'puntaje' => 78,
                'compras_realizadas' => 0,
                'notificaciones_activas' => true
            ],
            [
                'id' => 4,
                'nombre' => 'María Fernández',
                'email' => 'maria.fernandez@example.com',
                'telefono' => '5545678901',
                'edad' => 22,
                'fecha_nacimiento' => '2002-05-10',
                'menor_de_edad' => false,
                'tipo_sangre' => 'AB+',
                'genero' => 'Femenino',
                'direccion' => 'Pedregal 101, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '04500',
                'ocupacion' => 'Ingeniera',
                'nivel_estudios' => 'Universidad',
                'estado_civil' => 'Soltera',
                'activo' => true,
                'fecha_registro' => '2023-11-05',
                'ultimo_acceso' => '2024-06-15 08:15:00',
                'puntaje' => 10,
                'compras_realizadas' => 12,
                'notificaciones_activas' => true
            ],
            [
                'id' => 5,
                'nombre' => 'Jorge Ramírez',
                'email' => 'jorge.ramirez@example.com',
                'telefono' => '5556789012',
                'edad' => 30,
                'fecha_nacimiento' => '1994-12-01',
                'menor_de_edad' => false,
                'tipo_sangre' => 'O-',
                'genero' => 'Masculino',
                'direccion' => 'Santa Fe 202, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '05300',
                'ocupacion' => 'Médico',
                'nivel_estudios' => 'Posgrado',
                'estado_civil' => 'Casado',
                'activo' => true,
                'fecha_registro' => '2023-08-14',
                'ultimo_acceso' => '2024-06-14 18:30:00',
                'puntaje' => 50,
                'compras_realizadas' => 25,
                'notificaciones_activas' => false
            ],
            [
                'id' => 6,
                'nombre' => 'Sofía Castillo',
                'email' => 'sofia.castillo@example.com',
                'telefono' => '5567890123',
                'edad' => 12,
                'fecha_nacimiento' => '2012-07-19',
                'menor_de_edad' => true,
                'tipo_sangre' => 'A+',
                'genero' => 'Femenino',
                'direccion' => 'Coyoacán 345, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '04100',
                'ocupacion' => 'Estudiante',
                'nivel_estudios' => 'Primaria',
                'estado_civil' => 'Soltero',
                'activo' => true,
                'fecha_registro' => '2024-04-10',
                'ultimo_acceso' => '2024-06-12 16:20:00',
                'puntaje' => 45,
                'compras_realizadas' => 0,
                'notificaciones_activas' => true
            ],
            [
                'id' => 7,
                'nombre' => 'Diego Herrera',
                'email' => 'diego.herrera@example.com',
                'telefono' => '5578901234',
                'edad' => 45,
                'fecha_nacimiento' => '1979-09-25',
                'menor_de_edad' => false,
                'tipo_sangre' => 'B-',
                'genero' => 'Masculino',
                'direccion' => 'Polanco 567, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '11550',
                'ocupacion' => 'Empresario',
                'nivel_estudios' => 'Maestría',
                'estado_civil' => 'Casado',
                'activo' => true,
                'fecha_registro' => '2023-05-20',
                'ultimo_acceso' => '2024-06-15 11:00:00',
                'puntaje' => 53,
                'compras_realizadas' => 50,
                'notificaciones_activas' => true
            ],
            [
                'id' => 8,
                'nombre' => 'Valentina Ríos',
                'email' => 'valentina.rios@example.com',
                'telefono' => '5589012345',
                'edad' => 14,
                'fecha_nacimiento' => '2010-02-28',
                'menor_de_edad' => true,
                'tipo_sangre' => 'AB-',
                'genero' => 'Femenino',
                'direccion' => 'Roma Sur 890, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '06760',
                'ocupacion' => 'Estudiante',
                'nivel_estudios' => 'Secundaria',
                'estado_civil' => 'Soltero',
                'activo' => true,
                'fecha_registro' => '2024-01-25',
                'ultimo_acceso' => '2024-06-14 13:10:00',
                'puntaje' => 82,
                'compras_realizadas' => 0,
                'notificaciones_activas' => false
            ],
            [
                'id' => 9,
                'nombre' => 'Andrés López',
                'email' => 'andres.lopez@example.com',
                'telefono' => '5590123456',
                'edad' => 19,
                'fecha_nacimiento' => '2005-11-12',
                'menor_de_edad' => false,
                'tipo_sangre' => 'O+',
                'genero' => 'Masculino',
                'direccion' => 'Condesa 1234, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '06140',
                'ocupacion' => 'Estudiante universitario',
                'nivel_estudios' => 'Universidad',
                'estado_civil' => 'Soltero',
                'activo' => true,
                'fecha_registro' => '2024-03-01',
                'ultimo_acceso' => '2024-06-15 09:30:00',
                'puntaje' => 76,
                'compras_realizadas' => 3,
                'notificaciones_activas' => true
            ],
            [
                'id' => 10,
                'nombre' => 'Camila Núñez',
                'email' => 'camila.nunez@example.com',
                'telefono' => '5501234567',
                'edad' => 28,
                'fecha_nacimiento' => '1996-04-05',
                'menor_de_edad' => false,
                'tipo_sangre' => 'B+',
                'genero' => 'Femenino',
                'direccion' => 'Nápoles 5678, CDMX',
                'ciudad' => 'Ciudad de México',
                'pais' => 'México',
                'codigo_postal' => '03810',
                'ocupacion' => 'Arquitecta',
                'nivel_estudios' => 'Universidad',
                'estado_civil' => 'Unión libre',
                'activo' => true,
                'fecha_registro' => '2023-12-10',
                'ultimo_acceso' => '2024-06-13 17:45:00',
                'puntaje' => 91,
                'compras_realizadas' => 18,
                'notificaciones_activas' => true
            ]
        ];

        // res 1 debe leer los nombres, luego con un sort ordenarlos y luego mandarlos a un array
        // res 2 debe leet el tipo de sangre, luego contar cuantas coincidencias hay con un if y que lo muestre en un string
        // res 3 debe leer la edad y con una condicional de si es menor que 18, dejarlo pasar y asi saber los menores de edad
        // res 4 debe leer el mes de nacimiento, definir una variable por cada mes y mandar los nombres a cada mes
        // res 5 debe leer el estado civil, con un if, si es soltero mostrarlo, si no, no.
        // res 6 debe leer el puntaje y comparar si es >= 50, si se cumple, que muestre la condicion
      //  $usuarios['fecha_nacimiento']=Carbon::parse($usuarios['fecha_nacimiento']);
        $cantidad=count($usuarios);
        for($i=0; $i<=$cantidad-1; $i++){
            $usuarios[$i]['fecha_nacimiento'] = Carbon::parse($usuarios[$i]['fecha_nacimiento']);
        };

        //respuesta 1
        $usuariosPorNombre=$usuarios;
        usort($usuariosPorNombre, function($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });


        //respuesta 2


        $bloodAPlus='';
        $bloodAMinor='';
        $bloodBPlus='';
        $bloodBMinor='';
        $bloodOPlus='';
        $bloodOMinor='';
        $bloodABPlus='';
        $bloodABMinor='';
        $countBloodAPlus=0;
        $countBloodAMinor=0;
        $countBloodBPlus=0;
        $countBloodBMinor=0;
        $countBloodOPlus=0;
        $countBloodOMinor=0;
        $countBloodABPlus=0;
        $countBloodABMinor=0;

        for($i=0;$i<=$cantidad-1;$i++){
            if($usuarios[$i]['tipo_sangre']=='A+'){
                $bloodAPlus.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodAPlus++;
            }
            if($usuarios[$i]['tipo_sangre']=='A-'){
                $bloodAMinor.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodAMinor++;
            }
            if($usuarios[$i]['tipo_sangre']=='B+'){
                $bloodBPlus.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodBPlus++;
            }
            if($usuarios[$i]['tipo_sangre']=='B-'){
                $bloodBMinor.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodBMinor++;
            }
            if($usuarios[$i]['tipo_sangre']=='O+'){
                $bloodOPlus.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodOPlus++;
            }
            if($usuarios[$i]['tipo_sangre']=='O-'){
                $bloodOMinor.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodOMinor++;
            }
            if($usuarios[$i]['tipo_sangre']=='AB+'){
                $bloodABPlus.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodABPlus++;
            }
            if($usuarios[$i]['tipo_sangre']=='AB-'){
                $bloodABMinor.=' '.$usuarios[$i]['tipo_sangre'].' ';
                $countBloodABMinor++;
            }

        }

     /*  return 'Personas con el tipo de sangre A+ es:'.$countBloodAPlus.' '.
           'Personas con el tipo de sangre A- es:'.' '.$countBloodAMinor.' '.
           'Personas con el tipo de sangre B+ es:'.' '.$countBloodBPlus.' '.
           'Personas con el tipo de sangre B- es:'.' '.$countBloodBMinor.' '.
           'Personas con el tipo de sangre O+ es:'.' '.$countBloodOPlus.' '.
           'Personas con el tipo de sangre O- es:'.' '.$countBloodOMinor.' '.
           'personas con el tipo de sangre AB+ es:'.' '.$countBloodABPlus.' ' .
           'personas con el tipo de sangre AB- es:'.' '.$countBloodABMinor.' '; */

        //respuesta 3
        //Usuarios niños:

        $usuariosninos=[];
            for($i=0;$i<=$cantidad-1;$i++) {
                if ($usuarios[$i]['edad']<=17){
                    $usuariosninos[] = $usuarios[$i];
                }
            };


        //respuesta 4
        $usuariosPorMes=$usuarios;
            usort($usuariosPorMes, function ($a, $b) {
            return Carbon::parse($a['fecha_nacimiento'])->month<=>Carbon::parse($b['fecha_nacimiento'])->month;
        });


        //respuesta 5
        $cantidadSolteros=0;
        for($i=0; $i<=$cantidad-1; $i++){
            if($usuarios[$i]['estado_civil']=='Soltero'){
                $cantidadSolteros++;
            }
        }
     //   return response()->json('La cantidad de solteros es:'.' '.$cantidadSolteros);

        //respuesta 6

        $aprobados=[];
        for($i=0; $i<=$cantidad-1; $i++){
            if($usuarios[$i]['puntaje']>=50){
                $aprobados[$i]=$usuarios[$i];
            };

        }
        return response()->json([
            'Usuarios por Nombre' => $usuariosPorNombre,
            'Cuantos hay por tipo de sangre' => 'A+:'.$countBloodAPlus,
                                                'A-:'.$countBloodAMinor,
                                                'B+:'.$countBloodBPlus,
                                                'B-:'.$countBloodBMinor,
                                                'O+:'.$countBloodOPlus,
                                                'O-:'.$countBloodOMinor,
                                                'AB+:'.$countBloodABPlus,
                                                'AB-:'.$countBloodABMinor,
            'Menores de edad' => $usuariosninos,
            'Ordenados por Mes de Nacimiento' => $usuariosPorMes,
            'Cantidad de solteros' => $cantidadSolteros,
            'Aprobados' => $aprobados,
        ]);


//        return response()->json('Ordenados por nombre:'.$usuariosPorNombre.' '.'Cuantos hay por tipo de Sangre'.
//            'Personas con el tipo de sangre A+ es:'.$countBloodAPlus.' '.
//            'Personas con el tipo de sangre A- es:'.' '.$countBloodAMinor.' '.
//            'Personas con el tipo de sangre B+ es:'.' '.$countBloodBPlus.' '.
//            'Personas con el tipo de sangre B- es:'.' '.$countBloodBMinor.' '.
//            'Personas con el tipo de sangre O+ es:'.' '.$countBloodOPlus.' '.
//            'Personas con el tipo de sangre O- es:'.' '.$countBloodOMinor.' '.
//            'personas con el tipo de sangre AB+ es:'.' '.$countBloodABPlus.' ' .
//            'personas con el tipo de sangre AB- es:'.' '.$countBloodABMinor.' '.'Mostrar solo menores de edad'.$usuariosninos.' '
//            .'Ordenados por mes de nacimiento'.$usuariosPorMes.' '.'Cantidad de solteros:'.$cantidadSolteros.' '.'Usuarios aprobados:'.$aprobados);

     //   $usuarios=(object) $usuarios[1];
       // return $usuarios->edad;
        //-------------------------------------------------------->
       // return (object) $usuarios[1]->'edad';

        //return response()->json($arrespuestas);


        /* $a = 2;
        $b = 9;
        $c = 10;

         $ecuacionplus= ((-$b+sqrt(($b**2-(4*$a*$c))))/(2*$a));
         $ecuacionres= ((-$b-sqrt(($b**2-(4*$a*$c))))/(2*$a));
       /* //operacion multiplicacion dentro de la raiz
          $opmulraiz = $b**2-(4*$a*$c);
        //resutaldo raiz + -b
          $opresraizplusb = -$b + sqrt($opmulraiz);
        //resultado raiz - -b
          $opresraizresb = -$b - sqrt($opmulraiz);
        //multiplicacion de division
          $opmuldiv= 2*$a;
        //operacion entera
          $resultado1= $opresraizplusb/$opmuldiv;
          $resultado2= $opresraizresb/$opmuldiv;
        return response()->json('el resultado positivo es:'.' '.$resultado1.' '.'el resultado negativo es:'.' '.$resultado2);
         return response()->json('el resultado positivo es:'.' '.$ecuacionplus.' '.'el resultado negativo es:'.' '.$ecuacionres); */

     /*   $sig='*';
        $cantidad=5;
        $signo='*';
        for ($i=$cantidad;$i>=0;$i--){
            $fila=str_repeat($sig, $i);
            $res= $fila;
            $signo=$signo.$res."\n";

        };
            return response($signo)->header('Content-Type', 'text/plain'); */

        //representar la tabla de multip[licar de todos los numeros equisde
       /* for ($i=1; $i<=10; $i++) {
            for ($j=1; $j<=10; $j++) {
                $resultado[]=$i*$j;
            }
        }
        return response()->json($resultado);*/


        //numero sumado mas el numero anterior e imprimir resultado
        /*$arnumber=[0,1];
        for ($i = 2; $i <= 9; $i++) {
            $respuesta = $arnumber[$i-1]+$arnumber[$i-2];
            array_push($arnumber,$respuesta);
        }
        return response()->json($arnumber); */



       /* $disnumbers = [1, 5, 7, 10, 3, 6, 9, 2, 4, 8];
        $cantidad = count($disnumbers);

        for ($i = 0; $i < $cantidad; $i++) {
            for ($j = 0; $j < $cantidad - 1; $j++) {
                if ($disnumbers[$j] < $disnumbers[$j + 1]) {
                    $temp = $disnumbers[$j];
                    $disnumbers[$j] = $disnumbers[$j + 1];
                    $disnumbers[$j + 1] = $temp;
                }
            }
        }
        return response()->json($disnumbers); */


       /* $number=10;
        $equal=1;
        for($i=1;$i<=$number;$i++){
            $equal *= $i;
       }
        return response()->json($equal); */
    }
}
