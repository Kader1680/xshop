<div class="setting-field col-md-{{$setting->size}}">
    <label for="{{$setting->key}}">
        {{$setting->title}}

{{--        // WIP translate--}}
    </label>

    @switch($setting->type)
        @case('LONGTEXT')
            <textarea name="{{$setting->key}}"  @if($setting->ltr) dir="ltr" @endif id="{{$setting->key}}"
                      class="form-control"
                      rows="5">{{old($setting->key, $setting->value)}}</textarea>
            @break
        @case('CODE')
            <textarea dir="ltr" name="{{$setting->key}}" id="{{$setting->key}}"
                      class="form-control"
                      rows="5">{{old($setting->key, $setting->value)}}</textarea>
            @break
        @case('EDITOR')
            <textarea name="{{$setting->key}}" id="{{$setting->key}}"
                      class="form-control ckeditorx"
                      rows="5">{{old($setting->key, $setting->value)}}</textarea>
            @break
        @case('CHECKBOX')
            <select name="{{$setting->key}}" id="{{$setting->key}}"
                    class="form-control @error('status') is-invalid @enderror">
                <option value="1"
                        @if (old($setting->key, $setting->value??0) == '1' ) selected @endif >{{__("True")}} </option>
                <option value="0"
                        @if (old($setting->key, $setting->value??0) == '0' ) selected @endif >{{__("False")}} </option>
            </select>
            @break
        @case('CATEGORY')
            <searchable-select
                @error('category_id') :err="true" @enderror
                :items='@json($cats)'
                title-field="name"
                value-field="id"
                xlang="{{config('app.locale')}}"
                xid="{{$setting->key}}"
                xname="{{$setting->key}}"
                @error('category_id') :err="true" @enderror
                xvalue='{{old($setting->key,$setting->value??null)}}'
                :close-on-Select="true"></searchable-select>
            @break
        @case('GROUP')
            <searchable-select
                @error('category_id') :err="true" @enderror
                :items='@json($groups)'
                title-field="name"
                value-field="id"
                xlang="{{config('app.locale')}}"
                xid="{{$setting->key}}"
                xname="{{$setting->key}}"
                @error('category_id') :err="true" @enderror
                xvalue='{{old($setting->key,$setting->value??null)}}'
                :close-on-Select="true"></searchable-select>
            @break
        @case('FILE')
            <div class="row">
                @php($ext = strtolower(pathinfo(str_replace('_','.',$setting->key), PATHINFO_EXTENSION)))
                <div class="col-md-5 ">
                    <input type="file" accept=".{{pathinfo(str_replace('_','.',$setting->key), PATHINFO_EXTENSION)}}" class="form-control" name="file[{{$setting->key}}]" id="{{$setting->key}}">
                </div>
                @if(!in_array($ext, ['svg','jpg','png','gif','webp'] ) )
                    <div class="col-md-2">
                        <a class="btn btn-primary w-100" href="{{asset('upload/file/'.str_replace('_','.',$setting->key))}}?{{time()}}">
                            <i class="ri-download-2-line"></i>
                        </a>
                    </div>
                @endif
                <div class="col-md-5">
                    @if($ext == 'mp4')
                        <video controls src="{{asset('upload/file/'.str_replace('_','.',$setting->key))}}?{{time()}}" class="img-fluid" style="max-height: 150px;max-width: 45%" ></video>
                        <br>
                    @elseif($ext == 'mp3')
                        <audio controls src="{{asset('upload/file/'.str_replace('_','.',$setting->key))}}?{{time()}}" class="img-fluid" style="max-height: 150px;max-width: 45%" ></audio>
                        <br>
                    @elseif(in_array($ext, ['svg','jpg','png','gif','webp'] ) )
                        <img src="{{asset('upload/images/'.str_replace('_','.',$setting->key))}}?{{time()}}"
                             class="img-fluid" style="max-height: 150px;max-width: 45%" alt="{{$setting->key}}">
                    @endif
                </div>

            </div>
            @break
        @default
            @if($setting->key == 'optimize')
                <select  class="form-control" name="{{$setting->key}}" id="{{$setting->key}}">
                    <option value="1"
                            @if (old($setting->key, $setting->value??'webp') == 'jpg' ) selected @endif >{{__("jpg")}} </option>
                    <option value="0"
                            @if (old($setting->key, $setting->value??'webp') == 'webp' ) selected @endif >{{__("webp")}} </option>
                </select>
            @else
            <input type="text" id="{{$setting->key}}"
                   name="{{$setting->key}}" class="form-control"
                   value="{{old($setting->key, $setting->value)}}" @if($setting->ltr) dir="ltr" @endif>
            @endif
    @endswitch

</div>
