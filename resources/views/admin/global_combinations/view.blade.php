@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title"> {{ $data['name'] }} </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Product type</th>
                                <th>Metal type</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($data['form_data'] as $key => $value) { ?>
                                <?php $productInfo = getMasterById($value['product_type']); ?>
                                <?php $metalInfo = getMasterById($value['metal_types']); ?>
                                <tr>
                                    <td>{{  $key+1  }}</a></td>
                                    <td>{{  $productInfo['name']  }}</a></td>
                                    <td>{{  $metalInfo['name']  }}</td>
                                    <td><div class="sparkbar" data-color="#00a65a" data-height="20">{{ $value['price'] }}</div></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection