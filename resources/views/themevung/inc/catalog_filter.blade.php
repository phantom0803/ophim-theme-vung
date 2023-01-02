<ul class="locphim-category">
    <form class="form-filter" id="form_filter" method="GET">
        <li>
            <select name="filter[sort]" form="form-search" class="scroll bg-main-700 p-2 outline-none">
                <option value="">-- Sắp xếp --</option>
                <option value="update" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'update') selected @endif>Thời gian cập nhật</option>
                <option value="create" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'create') selected @endif>Thời gian đăng</option>
                <option value="year" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'year') selected @endif>Năm sản xuất</option>
                <option value="view" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'view') selected @endif>Lượt xem</option>
            </select>
        </li>
        <li>
            <select name="filter[type]" form="form-search" class="scroll bg-main-700 p-2 outline-none">
                <option value="">-- Định dạng --</option>
                <option value="series" @if (isset(request('filter')['type']) && request('filter')['type'] == 'series') selected @endif>Phim bộ</option>
                <option value="single" @if (isset(request('filter')['type']) && request('filter')['type'] == 'single') selected @endif>Phim lẻ</option>
            </select>
        </li>
        <li class="text-center">
            <select name="filter[region]" form="form-search" class="scroll bg-main-700 p-2 outline-none">
                <option value="">-- Quốc gia --</option>
                @foreach (\Ophim\Core\Models\Region::fromCache()->all() as $item)
                    <option value="{{ $item->id }}" @if ((isset(request('filter')['region']) && request('filter')['region'] == $item->id) ||
                        (isset($region) && $region->id == $item->id)) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <select name="filter[category]" form="form-search" class="scroll bg-main-700 p-2 outline-none">
                <option value="">-- Thể loại --</option>
                @foreach (\Ophim\Core\Models\Category::fromCache()->all() as $item)
                    <option value="{{ $item->id }}" @if ((isset(request('filter')['category']) && request('filter')['category'] == $item->id) ||
                        (isset($category) && $category->id == $item->id)) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <select class="form-control" name="filter[year]" form="form-search">
                <option value="">-- Năm phát hành --</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" @if (isset(request('filter')['year']) && request('filter')['year'] == $year) selected @endif>
                        {{ $year }}</option>
                @endforeach
            </select>
        </li>
        <li> <button type="submit" type="submit" form="form-search" class="submit-filter">Lọc Phim</button> </li>
    </form>
</ul>
