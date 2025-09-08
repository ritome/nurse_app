<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Employee ID -->
        <div>
            <x-input-label for="employee_id" :value="__('職員番号')" />
            <x-text-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')"
                required autofocus autocomplete="employee_id" placeholder="病院で割り当てられた職員番号を入力してください" />
            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
            <p class="mt-1 text-sm text-gray-600">※ 病院で割り当てられた職員番号をそのまま入力してください</p>
        </div>

        <!-- Full Name -->
        <div class="mt-4">
            <x-input-label for="full_name" :value="__('氏名')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')"
                required autocomplete="full_name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('役職')" />
            <select id="role" name="role"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="new_nurse">新入看護職員</option>
                <option value="partner_nurse">パートナー看護師</option>
                <option value="educator">教育係</option>
                <option value="chief">主任</option>
                <option value="manager_safety">課長（医療安全）</option>
                <option value="manager_infection">課長（感染制御）</option>
                <option value="manager_hrd">課長（人材育成）</option>
                <option value="director">部長</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Hire Date -->
        <div class="mt-4">
            <x-input-label for="hire_date" :value="__('入職日')" />
            <x-text-input id="hire_date" class="block mt-1 w-full" type="date" name="hire_date" :value="old('hire_date')"
                required />
            <x-input-error :messages="$errors->get('hire_date')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('パスワード')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('パスワード（確認用）')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('既に登録済みの方はこちら') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('登録') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
