<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\ItemImportService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $importService;

    public function __construct(ItemImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        $query = Item::query();

        // Search by item_no
        if (request()->has('item_no') && !empty(request('item_no'))) {
            $query->where('item_no', 'like', '%' . request('item_no') . '%');
        }

        // Search by item_name
        if (request()->has('item_name') && !empty(request('item_name'))) {
            $query->where('item_name', 'like', '%' . request('item_name') . '%');
        }

        $items = $query->paginate(10);
        return view('master.items.index', compact('items'));
    }

    public function create()
    {
        return view('master.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Item::rules());

        $item = new Item($validated);
        $item->save();

        return redirect()->route('master.items.index')
            ->with('success', '商品を登録しました。');
    }

    public function edit(Item $item)
    {
        return view('master.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $rules = Item::rules();
        $rules['item_no'] = 'required|string|max:10|unique:items,item_no,' . $item->item_no . ',item_no';

        $validated = $request->validate($rules);

        $item->update($validated);

        return redirect()->route('master.items.index')
            ->with('success', '商品を更新しました。');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('master.items.index')
            ->with('success', '商品を削除しました。');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        try {
            $result = $this->importService->import($request->file('csv_file'));

            if (!$result['success']) {
                $errorMessage = implode("\n", $result['errors']);
                return redirect()->route('master.items.index')
                    ->with('error', "インポート中にエラーが発生しました：\n" . $errorMessage);
            }

            $message = sprintf(
                '%d件の商品を登録、%d件の商品を更新しました。',
                $result['importCount'],
                $result['updateCount']
            );

            return redirect()->route('master.items.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('master.items.index')
                ->with('error', 'CSVインポートに失敗しました。: ' . $e->getMessage());
        }
    }
}
