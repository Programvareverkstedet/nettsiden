{ pkgs, lib }:

with lib;

{ }: let
  valueToString = val:
    if val == null then
      "null"
    else if isString val then
      builtins.toJSON val
    else if isBool val then
      boolToString val
    else if isInt val || isFloat val then
      toString val
    else if isList val then
      "array(${concatMapStringsSep ", " valueToString val})"
    else if isAttrs val && val ? value && (val._type or "") == "raw" then
      val.value
    else if isAttrs val then
      throw "Found unexpected attrs, that were not created by mkRaw. Have you put attrs in an array?\n${val}"
    else throw "unsupported :')";
in {
  inherit (pkgs.formats.json { }) type;

  generate = name: value: let
    flattenStructuredSettings = attrs: let
      partitionAttrs = pred: attrs: lib.pipe attrs [
        attrsToList
        (partition ({ name, value }: pred name value))
        (mapAttrs (_: listToAttrs))
      ];

      partitionedAttrs = partitionAttrs (_: v: isAttrs v && !(v ? value && (v._type or "") == "raw")) attrs;

      flattenedAttrs = lib.pipe partitionedAttrs.right [
        (mapAttrs (n1: mapAttrs' (n2: v2: nameValuePair "${n1}_${n2}" v2)))
        attrValues
        (map flattenStructuredSettings)
        (foldl recursiveUpdate { })
      ];
    in recursiveUpdate flattenedAttrs partitionedAttrs.wrong;

    content = lib.pipe value [
      flattenStructuredSettings
      (mapAttrs (_: valueToString))
      (mapAttrsToList (n: v: ''''$${n} = ${v};''))
      (concatStringsSep "\n")
      (content: "<?php\n${content}\n?>")
    ];
  in pkgs.writeText name content;

  lib = {
    inherit valueToString;

    mkRaw = value: {
      inherit value;
      _type = "raw";
    };

    types.raw = lib.types.attrs;
  };
}
