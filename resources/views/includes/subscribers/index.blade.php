@include('includes.index')
<div class="filters">
    <div class="form-row">
        <div class="form-group col-auto">
          <select id="inputState" class="form-control filter" data-pagename="subscribers" data-yearindex="{{ $identifier }}SubscribersYear" data-filtertype="{{$identifier}}" data-tableid="{{$identifier}}TableWrapper" data-index="plan">
            <option selected disabled>Filter By Plan</option>
            <option value="pro">Pro</option>
            <option value="turbo">Turbo</option>
          </select>
        </div>
        <div class="form-group col-auto">
          <select id="inputState" class="form-control filter" data-pagename="subscribers" data-yearindex="{{ $identifier }}SubscribersYear" data-filtertype="{{$identifier}}" data-tableid="{{$identifier}}TableWrapper" data-index="currency">
            <option selected disabled>Filter By Currency</option>
            <option value="USD">USD</option>
            <option value="NGN">Naira</option>
          </select>
        </div>
        <div class="form-group col-auto">
          <input type="text" placeholder="Filter By Date" class="form-control datepicker filter" data-pagename="subscribers" data-yearindex="{{ $identifier }}SubscribersYear" data-filtertype="{{$identifier}}" data-tableid="{{$identifier}}TableWrapper" data-index="date">
        </div>
        <div class="form-group col-4">
          <input type="text" placeholder="Filter By Date Interval" class="form-control datepicker interval filter" data-pagename="subscribers" data-yearindex="{{ $identifier }}SubscribersYear" data-filtertype="{{$identifier}}" data-tableid="{{$identifier}}TableWrapper" data-index="interval">
        </div>
    </div>
</div>
<div data-filter="{}" id="{{$identifier}}TableWrapper">
    @include('includes.filterables.tables.subscribers')
</div>